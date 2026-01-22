<?php

namespace App\Livewire\Pages\Dashboard\Transaksi;

use App\Models\Penjualan as PenjualanModel;
use App\Models\PenjualanItem;
use App\Models\Barang;
use App\Models\Stok;
use App\Models\Piutang;
use App\Models\Pendapatan;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Computed;

class PenjualanInput extends Component
{
    use WithFileUploads;

    #[Validate('nullable|max:50')]
    public $nama_pelanggan = '';

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
    public $stokPreview = 0;

    protected $messages = [
        'nama_pelanggan.required' => 'Nama pelanggan harus diisi',
        'nama_pelanggan.max' => 'Nama pelanggan maksimal 50 karakter',
        'pembayaran.required' => 'Metode pembayaran harus dipilih',
        'buktiFile.mimes' => 'File harus berupa jpg, jpeg, png, atau pdf',
        'buktiFile.max' => 'Ukuran file maksimal 5MB',
        'terbayar.required' => 'Jumlah terbayar harus diisi',
    ];

    #[Computed]
    public function totalPenjualan()
    {
        return array_sum(array_column($this->barangItems, 'subtotal')) ?? 0;
    }

    #[Computed]
    public function sisaPiutang()
    {
        $total = $this->totalPenjualan;
        $terbayar = floatval($this->terbayar) ?? 0;
        return max(0, $total - $terbayar);
    }

    #[Computed]
    public function kelebihan()
    {
        $total = $this->totalPenjualan;
        $terbayar = floatval($this->terbayar) ?? 0;
        return max(0, $terbayar - $total);
    }

    public function addItem()
    {
        $this->validate([
            'selectedBarang' => 'required|exists:barang,id',
            'jumlahItem' => 'required|integer|min:1',
        ], [
            'selectedBarang.required' => 'Pilih barang terlebih dahulu',
            'jumlahItem.required' => 'Jumlah harus diisi',
            'jumlahItem.min' => 'Jumlah minimal 1',
        ]);

        $barang = Barang::find($this->selectedBarang);

        if (!$barang) {
            $this->addError('selectedBarang', 'Barang tidak ditemukan');
            return;
        }

        $stok = Stok::where('barang_id', $this->selectedBarang)->first();
        if (!$stok || $stok->jumlah < $this->jumlahItem) {
            $this->addError('jumlahItem', 'Stok barang tidak cukup');
            return;
        }

        $subtotal = floatval($this->jumlahItem) * floatval($this->hargaJualPreview);

        $this->barangItems[] = [
            'barang_id' => $barang->id,
            'barang_nama' => $barang->nama,
            'satuan' => $barang->satuan->singkatan ?? $barang->satuan->nama,
            'harga_jual' => floatval($barang->harga),
            'jumlah' => (int)$this->jumlahItem,
            'harga' => floatval($this->hargaJualPreview),
            'subtotal' => $subtotal,
        ];

        $this->reset('selectedBarang', 'jumlahItem', 'hargaJualPreview', 'stokPreview');
        session()->flash('success', 'Item berhasil ditambahkan');
    }

    public function removeItem($index)
    {
        if (isset($this->barangItems[$index])) {
            unset($this->barangItems[$index]);
            $this->barangItems = array_values($this->barangItems);
            session()->flash('success', 'Item berhasil dihapus');
        }
    }

    public function updatedSelectedBarang()
    {
        if ($this->selectedBarang) {
            $barang = Barang::find($this->selectedBarang);
            if ($barang) {
                $this->hargaJualPreview = floatval($barang->harga);
                $stok = Stok::where('barang_id', $this->selectedBarang)->first();
                $this->stokPreview = $stok ? $stok->jumlah : 0;
            }
        } else {
            $this->hargaJualPreview = 0;
            $this->stokPreview = 0;
        }
    }

    public function save()
    {
        // Validasi dinamis berdasarkan sisa piutang
        $this->validate([
            'pembayaran' => 'required|in:cash,transfer',
            'terbayar' => 'required|numeric|min:0',
            'nama_pelanggan' => $this->sisaPiutang > 0 ? 'required|max:50' : 'nullable|max:50',
        ]);

        // Validasi bukti transfer
        if ($this->pembayaran === 'transfer' && !$this->buktiFile) {
            $this->addError('buktiFile', 'Bukti transfer harus diunggah untuk pembayaran transfer');
            return;
        }

        if (empty($this->barangItems)) {
            session()->flash('error', 'Minimal tambah 1 barang');
            return;
        }

        $total = $this->totalPenjualan;
        $terbayar = floatval($this->terbayar);

        if ($terbayar < 0) {
            $this->addError('terbayar', 'Jumlah terbayar tidak boleh negatif');
            return;
        }

        $buktiPath = null;
        if ($this->pembayaran === 'transfer' && $this->buktiFile) {
            $buktiPath = $this->buktiFile->store('penjualan', 'public');
        }

        try {
            $penjualan = PenjualanModel::create([
                'pembayaran' => $this->pembayaran,
                'bukti' => $buktiPath,
                'total' => $total,
            ]);

            foreach ($this->barangItems as $item) {
                PenjualanItem::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id' => $item['barang_id'],
                    'jumlah' => $item['jumlah'],
                ]);

                $stok = Stok::where('barang_id', $item['barang_id'])->first();
                if ($stok) {
                    $stok->jumlah -= $item['jumlah'];
                    $stok->save();
                }
            }

            if ($terbayar < $total) {
                Piutang::create([
                    'penjualan_id' => $penjualan->id,
                    'nama' => $this->nama_pelanggan,
                    'terbayar' => $terbayar,
                    'status' => 'belum',
                ]);
            }

            Pendapatan::create([
                'sumber' => 'Penjualan Barang',
                'pembayaran' => $this->pembayaran,
                'bukti' => $buktiPath ?? '',
                'jumlah' => $terbayar,
                'keterangan' => 'Penjualan barang pada pelanggan',
            ]);

            session()->flash('success', 'Penjualan berhasil ditambahkan');
            return redirect()->route('penjualan');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $barangs = Barang::with('satuan')->get();

        return view('livewire.pages.dashboard.transaksi.penjualan-input', [
            'barangs' => $barangs,
        ])->layout('layouts.dashboard');
    }
}
