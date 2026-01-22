<?php

namespace App\Livewire\Pages\Dashboard\Transaksi;

use App\Models\Penjualan as PenjualanModel;
use App\Models\PenjualanItem;
use App\Models\Barang;
use App\Models\Stok;
use App\Models\Piutang;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Computed;

class PenjualanDetail extends Component
{
    use WithFileUploads;

    public $penjualan_id;
    public $isEdit = false;

    #[Validate('required|max:50')]
    public $nama_pelanggan = '';

    #[Validate('required|in:cash,transfer')]
    public $pembayaran = 'cash';

    #[Validate('nullable|mimes:jpg,jpeg,png,pdf|max:5120')]
    public $buktiFile = null;

    public $barangItems = [];
    public $selectedBarang = '';
    public $jumlahItem = '';
    public $hargaItem = '';
    public $hargaJualPreview = 0;

    public function mount($id)
    {
        $penjualan = PenjualanModel::with(['penjualanItem', 'piutang'])->find($id);

        if (!$penjualan) {
            abort(404);
        }

        $this->penjualan_id = $penjualan->id;
        $this->pembayaran = $penjualan->pembayaran;

        if ($penjualan->piutang) {
            $this->nama_pelanggan = $penjualan->piutang->nama;
        }

        $this->barangItems = $penjualan->penjualanItem->map(function ($item) {
            return [
                'barang_id' => $item->barang_id,
                'barang_nama' => $item->barang->nama,
                'satuan' => $item->barang->satuan->singkatan ?? $item->barang->satuan->nama,
                'harga_jual' => floatval($item->barang->harga),
                'jumlah' => $item->jumlah,
                'harga' => floatval($item->barang->harga),
                'subtotal' => $item->jumlah * $item->barang->harga,
            ];
        })->toArray();
    }

    #[Computed]
    public function totalPenjualan()
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
                $this->jumlahItem = '';
                $this->hargaItem = floatval($barang->harga);
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

        try {
            $penjualan = PenjualanModel::with('penjualanItem')->find($this->penjualan_id);
            $oldItems = $penjualan->penjualanItem;
            $newTotal = $this->totalPenjualan;

            $penjualan->pembayaran = $this->pembayaran;
            $penjualan->total = $newTotal;
            $penjualan->save();

            foreach ($oldItems as $item) {
                $stok = Stok::where('barang_id', $item->barang_id)->first();
                if ($stok) {
                    $stok->jumlah += $item->jumlah;
                    $stok->save();
                }
            }

            PenjualanItem::where('penjualan_id', $this->penjualan_id)->delete();

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

            $piutang = Piutang::where('penjualan_id', $this->penjualan_id)->first();
            if ($piutang) {
                $piutang->delete();
            }

            $this->isEdit = false;
            session()->flash('success', 'Penjualan berhasil diperbarui');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $penjualan = PenjualanModel::with(['penjualanItem.barang', 'piutang'])->find($this->penjualan_id);
        $barangs = Barang::with('satuan')->get();

        return view('livewire.pages.dashboard.transaksi.penjualan-detail', [
            'penjualan' => $penjualan,
            'barangs' => $barangs,
        ])->layout('layouts.dashboard');
    }
}
