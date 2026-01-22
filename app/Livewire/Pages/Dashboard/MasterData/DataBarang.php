<?php

namespace App\Livewire\Pages\Dashboard\MasterData;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Satuan;
use App\Models\PembelianItem;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Computed;

class DataBarang extends Component
{
    use WithPagination;

    #[Validate('string|nullable|max:255')]
    public $search = '';

    public $showModal = false;
    public $isEdit = false;
    public $barang_id = null;

    #[Validate('required|exists:kategori_barang,id')]
    public $kategori_id = '';

    #[Validate('required|exists:satuan,id')]
    public $satuan_id = '';

    #[Validate('required|max:50')]
    public $nama = '';

    #[Validate('required|numeric|min:0')]
    public $harga = '';

    protected $messages = [
        'kategori_id.required' => 'Kategori harus dipilih',
        'satuan_id.required' => 'Satuan harus dipilih',
        'nama.required' => 'Nama barang harus diisi',
        'nama.max' => 'Nama barang maksimal 50 karakter',
        'harga.required' => 'Harga harus diisi',
        'harga.numeric' => 'Harga harus berupa angka',
        'harga.min' => 'Harga tidak boleh negatif',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->reset('kategori_id', 'satuan_id', 'nama', 'harga', 'barang_id', 'isEdit');
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function edit($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            session()->flash('error', 'Barang tidak ditemukan');
            return;
        }

        $this->barang_id = $barang->id;
        $this->kategori_id = $barang->kategori_id;
        $this->satuan_id = $barang->satuan_id;
        $this->nama = $barang->nama;
        $this->harga = $barang->harga;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        try {
            if ($this->isEdit) {
                $this->validate([
                    'kategori_id' => 'required|exists:kategori_barang,id',
                    'satuan_id' => 'required|exists:satuan,id',
                    'nama' => 'required|max:50|unique:barang,nama,' . $this->barang_id,
                    'harga' => 'required|numeric|min:0',
                ]);

                $barang = Barang::find($this->barang_id);
                if (!$barang) {
                    session()->flash('error', 'Barang tidak ditemukan');
                    return;
                }

                $barang->update([
                    'kategori_id' => $this->kategori_id,
                    'satuan_id' => $this->satuan_id,
                    'nama' => $this->nama,
                    'harga' => $this->harga,
                ]);

                $message = 'Data barang berhasil diperbarui';
            } else {
                $this->validate([
                    'kategori_id' => 'required|exists:kategori_barang,id',
                    'satuan_id' => 'required|exists:satuan,id',
                    'nama' => 'required|max:50|unique:barang,nama',
                    'harga' => 'required|numeric|min:0',
                ]);

                Barang::create([
                    'kategori_id' => $this->kategori_id,
                    'satuan_id' => $this->satuan_id,
                    'nama' => $this->nama,
                    'harga' => $this->harga,
                ]);

                $message = 'Data barang berhasil ditambahkan';
            }

            $this->closeModal();
            session()->flash('success', $message);
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $barang = Barang::find($id);

            if (!$barang) {
                session()->flash('error', 'Barang tidak ditemukan');
                return;
            }

            // Check if barang is used in pembelian items
            $pembelianCount = PembelianItem::where('barang_id', $id)->count();
            if ($pembelianCount > 0) {
                session()->flash('error', 'Tidak dapat menghapus barang yang sudah digunakan dalam transaksi');
                return;
            }

            $barang->delete();
            session()->flash('success', 'Data barang berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getHargaBeli($barangId)
    {
        $pembelianItem = PembelianItem::where('barang_id', $barangId)
            ->latest()
            ->first();

        return $pembelianItem ? $pembelianItem->harga : 0;
    }

    #[Computed]
    public function barangsData()
    {
        return Barang::with(['kategori', 'satuan'])
            ->where(function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhereHas('kategori', function ($q) {
                        $q->where('nama', 'like', '%' . $this->search . '%');
                    });
            })
            ->paginate(10);
    }

    public function render()
    {
        $barangs = $this->barangsData;
        $kategoris = KategoriBarang::all();
        $satuans = Satuan::all();

        $barangsData = $barangs->map(function ($barang) {
            $hargaBeli = $this->getHargaBeli($barang->id);
            $hargaJual = $barang->harga;
            $laba = $hargaJual - $hargaBeli;

            return [
                'id' => $barang->id,
                'nama' => $barang->nama,
                'kategori' => $barang->kategori->nama,
                'satuan' => $barang->satuan->singkatan ?? $barang->satuan->nama,
                'harga_beli' => $hargaBeli,
                'harga_jual' => $hargaJual,
                'laba' => $laba,
                'created_at' => $barang->created_at,
            ];
        });

        return view('livewire.pages.dashboard.master-data.data-barang', [
            'barangs' => $barangsData,
            'paginator' => $barangs,
            'kategoris' => $kategoris,
            'satuans' => $satuans,
        ])->layout('layouts.dashboard');
    }
}
