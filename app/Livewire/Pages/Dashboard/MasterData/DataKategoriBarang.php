<?php

namespace App\Livewire\Pages\Dashboard\MasterData;

use App\Models\KategoriBarang;
use Livewire\Component;
use Livewire\WithPagination;

class DataKategoriBarang extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $isEdit = false;
    public $kategori_id = null;

    public $nama = '';
    public $keterangan = '';

    protected $rules = [
        'nama' => 'required|max:50|unique:kategori_barang,nama',
        'keterangan' => 'nullable|max:500',
    ];

    protected $messages = [
        'nama.required' => 'Nama kategori harus diisi',
        'nama.unique' => 'Nama kategori sudah ada',
        'nama.max' => 'Nama kategori maksimal 50 karakter',
        'keterangan.max' => 'Keterangan maksimal 500 karakter',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->reset('nama', 'keterangan', 'kategori_id', 'isEdit');
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function edit($id)
    {
        $kategori = KategoriBarang::find($id);

        if (!$kategori) {
            return;
        }

        $this->kategori_id = $kategori->id;
        $this->nama = $kategori->nama;
        $this->keterangan = $kategori->keterangan;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->isEdit) {
            $this->validate([
                'nama' => 'required|max:50|unique:kategori_barang,nama,' . $this->kategori_id,
                'keterangan' => 'nullable|max:500',
            ]);

            $kategori = KategoriBarang::find($this->kategori_id);
            $kategori->nama = $this->nama;
            $kategori->keterangan = $this->keterangan;
            $kategori->save();

            $message = 'Data kategori barang berhasil diperbarui';
        } else {
            $this->validate();

            KategoriBarang::create([
                'nama' => $this->nama,
                'keterangan' => $this->keterangan,
            ]);

            $message = 'Data kategori barang berhasil ditambahkan';
        }

        $this->closeModal();
        session()->flash('success', $message);
    }

    public function delete($id)
    {
        $kategori = KategoriBarang::find($id);

        if ($kategori) {
            $kategori->delete();
            session()->flash('success', 'Data kategori barang berhasil dihapus');
        }
    }

    public function render()
    {
        $kategoris = KategoriBarang::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('keterangan', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.pages.dashboard.master-data.data-kategori-barang', [
            'kategoris' => $kategoris,
        ])->layout('layouts.dashboard');
    }
}
