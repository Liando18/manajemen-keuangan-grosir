<?php

namespace App\Livewire\Pages\Dashboard\MasterData;

use App\Models\Satuan;
use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class DataSatuan extends Component
{
    use WithPagination;

    #[Validate('string|nullable|max:255')]
    public $search = '';

    public $showModal = false;
    public $isEdit = false;
    public $satuan_id = null;

    #[Validate('required|max:50|unique:satuan,nama')]
    public $nama = '';

    #[Validate('nullable|max:10|unique:satuan,singkatan')]
    public $singkatan = '';

    #[Validate('nullable|max:500')]
    public $keterangan = '';

    protected $messages = [
        'nama.required' => 'Nama satuan harus diisi',
        'nama.max' => 'Nama satuan maksimal 50 karakter',
        'nama.unique' => 'Nama satuan sudah ada',
        'singkatan.max' => 'Singkatan maksimal 10 karakter',
        'singkatan.unique' => 'Singkatan sudah ada',
        'keterangan.max' => 'Keterangan maksimal 500 karakter',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->reset('nama', 'singkatan', 'keterangan', 'satuan_id', 'isEdit');
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function edit($id)
    {
        $satuan = Satuan::find($id);

        if (!$satuan) {
            session()->flash('error', 'Satuan tidak ditemukan');
            return;
        }

        $this->satuan_id = $satuan->id;
        $this->nama = $satuan->nama;
        $this->singkatan = $satuan->singkatan ?? '';
        $this->keterangan = $satuan->keterangan ?? '';
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        try {
            if ($this->isEdit) {
                $this->validate([
                    'nama' => 'required|max:50|unique:satuan,nama,' . $this->satuan_id,
                    'singkatan' => 'nullable|max:10|unique:satuan,singkatan,' . $this->satuan_id,
                    'keterangan' => 'nullable|max:500',
                ]);

                $satuan = Satuan::find($this->satuan_id);
                if (!$satuan) {
                    session()->flash('error', 'Satuan tidak ditemukan');
                    return;
                }

                $satuan->update([
                    'nama' => $this->nama,
                    'singkatan' => $this->singkatan ?: null,
                    'keterangan' => $this->keterangan ?: null,
                ]);

                $message = 'Data satuan berhasil diperbarui';
            } else {
                $this->validate([
                    'nama' => 'required|max:50|unique:satuan,nama',
                    'singkatan' => 'nullable|max:10|unique:satuan,singkatan',
                    'keterangan' => 'nullable|max:500',
                ]);

                Satuan::create([
                    'nama' => $this->nama,
                    'singkatan' => $this->singkatan ?: null,
                    'keterangan' => $this->keterangan ?: null,
                ]);

                $message = 'Data satuan berhasil ditambahkan';
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
            $satuan = Satuan::find($id);

            if (!$satuan) {
                session()->flash('error', 'Satuan tidak ditemukan');
                return;
            }

            // Check if satuan is used in barang
            $barangCount = Barang::where('satuan_id', $id)->count();
            if ($barangCount > 0) {
                session()->flash('error', "Tidak dapat menghapus satuan ini karena sudah digunakan oleh $barangCount barang");
                return;
            }

            $satuan->delete();
            session()->flash('success', 'Data satuan berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $satuans = Satuan::where(function ($query) {
            $query->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('singkatan', 'like', '%' . $this->search . '%')
                ->orWhere('keterangan', 'like', '%' . $this->search . '%');
        })
            ->withCount('barang')
            ->latest()
            ->paginate(10);

        return view('livewire.pages.dashboard.master-data.data-satuan', [
            'satuans' => $satuans,
        ])->layout('layouts.dashboard');
    }
}
