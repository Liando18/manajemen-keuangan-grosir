<?php

namespace App\Livewire\Pages\Dashboard\Keuangan;

use App\Models\Pengeluaran as PengeluaranModel;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class Pengeluaran extends Component
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
        'sumber.required' => 'Sumber pengeluaran harus diisi',
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
        $pengeluaran = PengeluaranModel::find($id);

        if (!$pengeluaran) {
            session()->flash('error', 'Data tidak ditemukan');
            return;
        }

        $this->editingId = $id;
        $this->sumber = $pengeluaran->sumber;
        $this->pembayaran = $pengeluaran->pembayaran;
        $this->jumlah = $pengeluaran->jumlah;
        $this->keterangan = $pengeluaran->keterangan;
        $this->buktiPath = $pengeluaran->bukti;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        try {
            $bukti = $this->buktiPath;

            if ($this->buktiFile) {
                $bukti = $this->buktiFile->store('pengeluaran', 'public');
            }

            if ($this->editingId) {
                $pengeluaran = PengeluaranModel::find($this->editingId);

                if (!$pengeluaran) {
                    session()->flash('error', 'Data tidak ditemukan');
                    return;
                }

                $pengeluaran->update([
                    'sumber' => $this->sumber,
                    'pembayaran' => $this->pembayaran,
                    'bukti' => $bukti ?? '',
                    'jumlah' => $this->jumlah,
                    'keterangan' => $this->keterangan,
                ]);

                session()->flash('success', 'Pengeluaran berhasil diperbarui');
            } else {
                PengeluaranModel::create([
                    'sumber' => $this->sumber,
                    'pembayaran' => $this->pembayaran,
                    'bukti' => $bukti ?? '',
                    'jumlah' => $this->jumlah,
                    'keterangan' => $this->keterangan,
                ]);

                session()->flash('success', 'Pengeluaran berhasil ditambahkan');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $pengeluaran = PengeluaranModel::find($id);

            if (!$pengeluaran) {
                session()->flash('error', 'Data tidak ditemukan');
                return;
            }

            $pengeluaran->delete();
            session()->flash('success', 'Pengeluaran berhasil dihapus');
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
        $pengeluarans = PengeluaranModel::when($this->search, function ($query) {
            $query->where('sumber', 'like', '%' . $this->search . '%')
                ->orWhere('keterangan', 'like', '%' . $this->search . '%');
        })
            ->latest()
            ->paginate(10);

        $totalPengeluaran = PengeluaranModel::sum('jumlah');

        return view('livewire.pages.dashboard.keuangan.pengeluaran', [
            'pengeluarans' => $pengeluarans,
            'totalPengeluaran' => $totalPengeluaran,
        ])->layout('layouts.dashboard');
    }
}
