<?php

namespace App\Livewire\Pages\Dashboard\Transaksi;

use App\Models\Pembelian as PembelianModel;
use App\Models\PembelianItem;
use App\Models\Supplier;
use App\Models\Barang;
use App\Models\Stok;
use App\Models\Hutang;
use App\Models\Pengeluaran;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Computed;

class PembelianInput extends Component
{
    use WithFileUploads;

    #[Validate('required|exists:supplier,id')]
    public $supplier_id = '';

    #[Validate('required|in:cash,transfer')]
    public $pembayaran = 'cash';

    #[Validate('nullable|mimes:jpg,jpeg,png,pdf|max:5120')]
    public $buktiFile = null;

    #[Validate('required|numeric|min:0')]
    public $terbayar = '';

    public $barangItems = [];
    public $selectedBarang = '';
    public $jumlahItem = '';
    public $hargaItem = '';
    public $hargaJualPreview = 0;

    protected $messages = [
        'supplier_id.required' => 'Supplier harus dipilih',
        'pembayaran.required' => 'Metode pembayaran harus dipilih',
        'buktiFile.mimes' => 'File harus berupa jpg, jpeg, png, atau pdf',
        'buktiFile.max' => 'Ukuran file maksimal 5MB',
        'terbayar.required' => 'Jumlah terbayar harus diisi',
    ];

    #[Computed]
    public function totalPembelian()
    {
        return array_sum(array_column($this->barangItems, 'subtotal')) ?? 0;
    }

    #[Computed]
    public function sisaHutang()
    {
        $total = $this->totalPembelian;
        $terbayar = floatval($this->terbayar) ?? 0;
        return max(0, $total - $terbayar);
    }

    #[Computed]
    public function kelebihan()
    {
        $total = $this->totalPembelian;
        $terbayar = floatval($this->terbayar) ?? 0;
        return max(0, $terbayar - $total);
    }

    public function addItem()
    {
        $this->validate([
            'selectedBarang' => 'required|exists:barang,id',
            'jumlahItem' => 'required|integer|min:1',
            'hargaItem' => 'required|numeric|min:0',
        ], [
            'selectedBarang.required' => 'Pilih barang terlebih dahulu',
            'jumlahItem.required' => 'Jumlah harus diisi',
            'jumlahItem.min' => 'Jumlah minimal 1',
            'hargaItem.required' => 'Harga harus diisi',
        ]);

        $barang = Barang::find($this->selectedBarang);

        if (!$barang) {
            $this->addError('selectedBarang', 'Barang tidak ditemukan');
            return;
        }

        $subtotal = floatval($this->jumlahItem) * floatval($this->hargaItem);

        $this->barangItems[] = [
            'barang_id' => $barang->id,
            'barang_nama' => $barang->nama,
            'satuan' => $barang->satuan->singkatan ?? $barang->satuan->nama,
            'harga_jual' => floatval($barang->harga),
            'jumlah' => (int)$this->jumlahItem,
            'harga' => floatval($this->hargaItem),
            'subtotal' => $subtotal,
        ];

        $this->reset('selectedBarang', 'jumlahItem', 'hargaItem', 'hargaJualPreview');
        session()->flash('success', 'Item berhasil ditambahkan');
    }

    public function updatedSelectedBarang()
    {
        if ($this->selectedBarang) {
            $barang = Barang::find($this->selectedBarang);
            if ($barang) {
                $this->hargaJualPreview = floatval($barang->harga);
            }
        } else {
            $this->hargaJualPreview = 0;
        }
    }

    public function removeItem($index)
    {
        if (isset($this->barangItems[$index])) {
            unset($this->barangItems[$index]);
            $this->barangItems = array_values($this->barangItems);
            session()->flash('success', 'Item berhasil dihapus');
        }
    }

    public function save()
    {
        $this->validate();

        if (empty($this->barangItems)) {
            session()->flash('error', 'Minimal tambah 1 barang');
            return;
        }

        if ($this->pembayaran === 'transfer' && !$this->buktiFile) {
            $this->addError('buktiFile', 'Bukti transfer harus diunggah untuk pembayaran transfer');
            return;
        }

        $total = $this->totalPembelian;
        $terbayar = floatval($this->terbayar);

        if ($terbayar < 0) {
            $this->addError('terbayar', 'Jumlah terbayar tidak boleh negatif');
            return;
        }

        $buktiPath = null;
        if ($this->pembayaran === 'transfer' && $this->buktiFile) {
            $buktiPath = $this->buktiFile->store('pembelian', 'public');
        }

        try {
            $pembelian = PembelianModel::create([
                'supplier_id' => $this->supplier_id,
                'pembayaran' => $this->pembayaran,
                'bukti' => $buktiPath,
                'total' => $total,
            ]);

            foreach ($this->barangItems as $item) {
                PembelianItem::create([
                    'pembelian_id' => $pembelian->id,
                    'barang_id' => $item['barang_id'],
                    'jumlah' => $item['jumlah'],
                    'harga' => $item['harga'],
                ]);

                $stok = Stok::where('barang_id', $item['barang_id'])->first();
                if ($stok) {
                    $stok->jumlah += $item['jumlah'];
                    $stok->save();
                } else {
                    Stok::create([
                        'barang_id' => $item['barang_id'],
                        'jumlah' => $item['jumlah'],
                    ]);
                }
            }

            if ($terbayar < $total) {
                Hutang::create([
                    'pembelian_id' => $pembelian->id,
                    'supplier_id' => $this->supplier_id,
                    'terbayar' => $terbayar,
                    'status' => 'belum',
                ]);
            }

            // Tambahkan data pengeluaran
            Pengeluaran::create([
                'sumber' => 'Pembelian Barang',
                'pembayaran' => $this->pembayaran,
                'bukti' => $buktiPath ?? '',
                'jumlah' => $terbayar,
                'keterangan' => 'Pembelian barang sama supplier',
            ]);

            session()->flash('success', 'Pembelian berhasil ditambahkan');
            return redirect()->route('pembelian');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $suppliers = Supplier::all();
        $barangs = Barang::with('satuan')->get();

        return view('livewire.pages.dashboard.transaksi.pembelian-input', [
            'suppliers' => $suppliers,
            'barangs' => $barangs,
        ])->layout('layouts.dashboard');
    }
}
