<?php

namespace App\Livewire\Pages\Dashboard\MasterData;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class DataSupplier extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $isEdit = false;
    public $supplier_id = null;

    public $nama = '';
    public $kontak = '';
    public $alamat = '';

    protected $rules = [
        'nama' => 'required|max:50|unique:supplier,nama',
        'kontak' => 'required|max:50',
        'alamat' => 'required|max:500',
    ];

    protected $messages = [
        'nama.required' => 'Nama supplier harus diisi',
        'nama.unique' => 'Nama supplier sudah ada',
        'nama.max' => 'Nama supplier maksimal 50 karakter',
        'kontak.required' => 'Kontak harus diisi',
        'kontak.max' => 'Kontak maksimal 50 karakter',
        'alamat.required' => 'Alamat harus diisi',
        'alamat.max' => 'Alamat maksimal 500 karakter',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->reset('nama', 'kontak', 'alamat', 'supplier_id', 'isEdit');
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return;
        }

        $this->supplier_id = $supplier->id;
        $this->nama = $supplier->nama;
        $this->kontak = $supplier->kontak;
        $this->alamat = $supplier->alamat;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->isEdit) {
            $this->validate([
                'nama' => 'required|max:50|unique:supplier,nama,' . $this->supplier_id,
                'kontak' => 'required|max:50',
                'alamat' => 'required|max:500',
            ]);

            $supplier = Supplier::find($this->supplier_id);
            $supplier->nama = $this->nama;
            $supplier->kontak = $this->kontak;
            $supplier->alamat = $this->alamat;
            $supplier->save();

            $message = 'Data supplier berhasil diperbarui';
        } else {
            $this->validate();

            Supplier::create([
                'nama' => $this->nama,
                'kontak' => $this->kontak,
                'alamat' => $this->alamat,
            ]);

            $message = 'Data supplier berhasil ditambahkan';
        }

        $this->closeModal();
        session()->flash('success', $message);
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id);

        if ($supplier) {
            $supplier->delete();
            session()->flash('success', 'Data supplier berhasil dihapus');
        }
    }

    public function render()
    {
        $suppliers = Supplier::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('kontak', 'like', '%' . $this->search . '%')
            ->orWhere('alamat', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.pages.dashboard.master-data.data-supplier', [
            'suppliers' => $suppliers,
        ])->layout('layouts.dashboard');
    }
}
