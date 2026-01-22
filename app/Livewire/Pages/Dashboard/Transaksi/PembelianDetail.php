<?php

namespace App\Livewire\Pages\Dashboard\Transaksi;

use App\Models\Pembelian as PembelianModel;
use App\Models\PembelianItem;
use App\Models\Supplier;
use App\Models\Barang;
use App\Models\Stok;
use App\Models\Hutang;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Computed;

class PembelianDetail extends Component
{
    use WithFileUploads;

    public $pembelian_id;
    public $isEdit = false;

    #[Validate('required|exists:supplier,id')]
    public $supplier_id = '';

    #[Validate('required|in:cash,transfer')]
    public $pembayaran = 'cash';

    #[Validate('nullable|max:500')]
    public $bukti = '';

    #[Validate('nullable|mimes:jpg,jpeg,png,pdf|max:5120')]
    public $buktiFile = null;

    public $barangItems = [];
    public $selectedBarang = '';
    public $jumlahItem = '';
    public $hargaItem = '';
    public $hargaJualPreview = 0;

    public function mount($id)
    {
        $pembelian = PembelianModel::with(['pembelianItem', 'hutang'])->find($id);

        if (!$pembelian) {
            abort(404);
        }

        $this->pembelian_id = $pembelian->id;
        $this->supplier_id = $pembelian->supplier_id;
        $this->pembayaran = $pembelian->pembayaran;
        $this->bukti = $pembelian->bukti ?? '';

        $this->barangItems = $pembelian->pembelianItem->map(function ($item) {
            return [
                'barang_id' => $item->barang_id,
                'barang_nama' => $item->barang->nama,
                'satuan' => $item->barang->satuan->singkatan ?? $item->barang->satuan->nama,
                'harga_jual' => floatval($item->barang->harga),
                'jumlah' => $item->jumlah,
                'harga' => $item->harga,
                'subtotal' => $item->jumlah * $item->harga,
            ];
        })->toArray();
    }

    #[Computed]
    public function totalPembelian()
    {
        return array_sum(array_column($this->barangItems, 'subtotal')) ?? 0;
    }

    public function toggleEdit()
    {
        $this->isEdit = !$this->isEdit;
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
            }
        } else {
            $this->hargaJualPreview = 0;
        }
    }

    public function save()
    {
        $this->validate();

        if (empty($this->barangItems)) {
            session()->flash('error', 'Minimal tambah 1 barang');
            return;
        }

        if ($this->pembayaran === 'transfer' && !$this->buktiFile && !$this->bukti) {
            $this->addError('buktiFile', 'Bukti transfer harus diunggah untuk pembayaran transfer');
            return;
        }

        try {
            $pembelian = PembelianModel::with('pembelianItem')->find($this->pembelian_id);
            $oldItems = $pembelian->pembelianItem;
            $newTotal = $this->totalPembelian;

            $pembelian->supplier_id = $this->supplier_id;
            $pembelian->pembayaran = $this->pembayaran;

            if ($this->buktiFile) {
                if ($pembelian->bukti && \Storage::disk('public')->exists($pembelian->bukti)) {
                    \Storage::disk('public')->delete($pembelian->bukti);
                }
                $pembelian->bukti = $this->buktiFile->store('pembelian', 'public');
            } elseif ($this->pembayaran === 'cash') {
                $pembelian->bukti = $this->bukti;
            }

            $pembelian->total = $newTotal;
            $pembelian->save();

            foreach ($oldItems as $item) {
                $stok = Stok::where('barang_id', $item->barang_id)->first();
                if ($stok) {
                    $stok->jumlah -= $item->jumlah;
                    if ($stok->jumlah < 0) {
                        $stok->jumlah = 0;
                    }
                    $stok->save();
                }
            }

            PembelianItem::where('pembelian_id', $this->pembelian_id)->delete();

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

            $hutang = Hutang::where('pembelian_id', $this->pembelian_id)->first();
            if ($hutang) {
                $hutang->delete();
            }

            $this->isEdit = false;
            session()->flash('success', 'Pembelian berhasil diperbarui');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $pembelian = PembelianModel::with(['supplier', 'pembelianItem.barang', 'hutang'])->find($this->pembelian_id);
        $suppliers = Supplier::all();
        $barangs = Barang::with('satuan')->get();

        return view('livewire.pages.dashboard.transaksi.pembelian-detail', [
            'pembelian' => $pembelian,
            'suppliers' => $suppliers,
            'barangs' => $barangs,
        ])->layout('layouts.dashboard');
    }
}
