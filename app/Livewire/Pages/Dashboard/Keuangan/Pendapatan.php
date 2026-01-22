<?php

namespace App\Livewire\Pages\Dashboard\Keuangan;

use App\Models\Pendapatan as PendapatanModel;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class Pendapatan extends Component
{
    use WithFileUploads, WithPagination;

    #[Validate('required|string|max:50')]
    public $sumber = '';

    #[Validate('required|in:cash,transfer')]
    public $pembayaran = 'cash';

    #[Validate('nullable|mimes:jpg,jpeg,png,pdf|max:5120')]
    public $buktiFile = null;

    #[Validate('required|numeric|min:0')]
    public $jumlah = '';

    #[Validate('required|string')]
    public $keterangan = '';

    public $search = '';
    public $showModal = false;
    public $editingId = null;
    public $buktiPath = null;

    protected $messages = [
        'sumber.required' => 'Sumber pendapatan harus diisi',
        'sumber.max' => 'Sumber maksimal 50 karakter',
        'pembayaran.required' => 'Metode pembayaran harus dipilih',
        'buktiFile.mimes' => 'File harus berupa jpg, jpeg, png, atau pdf',
        'buktiFile.max' => 'Ukuran file maksimal 5MB',
        'jumlah.required' => 'Jumlah harus diisi',
        'jumlah.numeric' => 'Jumlah harus berupa angka',
        'jumlah.min' => 'Jumlah tidak boleh negatif',
        'keterangan.required' => 'Keterangan harus diisi',
    ];

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $pendapatan = PendapatanModel::find($id);

        if (!$pendapatan) {
            session()->flash('error', 'Data tidak ditemukan');
            return;
        }

        $this->editingId = $id;
        $this->sumber = $pendapatan->sumber;
        $this->pembayaran = $pendapatan->pembayaran;
        $this->jumlah = $pendapatan->jumlah;
        $this->keterangan = $pendapatan->keterangan;
        $this->buktiPath = $pendapatan->bukti;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        try {
            $bukti = $this->buktiPath;

            if ($this->buktiFile) {
                $bukti = $this->buktiFile->store('pendapatan', 'public');
            }

            if ($this->editingId) {
                $pendapatan = PendapatanModel::find($this->editingId);

                if (!$pendapatan) {
                    session()->flash('error', 'Data tidak ditemukan');
                    return;
                }

                $pendapatan->update([
                    'sumber' => $this->sumber,
                    'pembayaran' => $this->pembayaran,
                    'bukti' => $bukti ?? '',
                    'jumlah' => $this->jumlah,
                    'keterangan' => $this->keterangan,
                ]);

                session()->flash('success', 'Pendapatan berhasil diperbarui');
            } else {
                PendapatanModel::create([
                    'sumber' => $this->sumber,
                    'pembayaran' => $this->pembayaran,
                    'bukti' => $bukti ?? '',
                    'jumlah' => $this->jumlah,
                    'keterangan' => $this->keterangan,
                ]);

                session()->flash('success', 'Pendapatan berhasil ditambahkan');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $pendapatan = PendapatanModel::find($id);

            if (!$pendapatan) {
                session()->flash('error', 'Data tidak ditemukan');
                return;
            }

            $pendapatan->delete();
            session()->flash('success', 'Pendapatan berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->showModal = false;
    }

    public function resetForm()
    {
        $this->sumber = '';
        $this->pembayaran = 'cash';
        $this->buktiFile = null;
        $this->buktiPath = null;
        $this->jumlah = '';
        $this->keterangan = '';
        $this->editingId = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        $pendapatans = PendapatanModel::when($this->search, function ($query) {
            $query->where('sumber', 'like', '%' . $this->search . '%')
                ->orWhere('keterangan', 'like', '%' . $this->search . '%');
        })
            ->latest()
            ->paginate(10);

        $totalPendapatan = PendapatanModel::sum('jumlah');

        return view('livewire.pages.dashboard.keuangan.pendapatan', [
            'pendapatans' => $pendapatans,
            'totalPendapatan' => $totalPendapatan,
        ])->layout('layouts.dashboard');
    }
}
