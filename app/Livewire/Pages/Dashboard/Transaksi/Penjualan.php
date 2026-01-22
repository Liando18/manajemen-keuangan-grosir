<?php

namespace App\Livewire\Pages\Dashboard\Transaksi;

use App\Models\Penjualan as PenjualanModel;
use App\Models\Piutang;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class Penjualan extends Component
{
    use WithPagination;

    #[Validate('string|nullable|max:255')]
    public $search = '';

    public $filterPembayaran = '';
    public $sortBy = 'latest';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterPembayaran' => ['except' => ''],
        'sortBy' => ['except' => 'latest'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterPembayaran()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        try {
            $penjualan = PenjualanModel::with(['penjualanItem'])->find($id);

            if (!$penjualan) {
                session()->flash('error', 'Penjualan tidak ditemukan');
                return;
            }

            $piutang = Piutang::where('penjualan_id', $id)->first();
            if ($piutang) {
                $piutang->delete();
            }

            if ($penjualan->bukti) {
                \Storage::disk('public')->delete($penjualan->bukti);
            }

            $penjualan->delete();
            session()->flash('success', 'Penjualan berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus penjualan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = PenjualanModel::with(['penjualanItem', 'piutang']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('bukti', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterPembayaran) {
            $query->where('pembayaran', $this->filterPembayaran);
        }

        match ($this->sortBy) {
            'oldest' => $query->oldest(),
            'total_asc' => $query->orderBy('total', 'asc'),
            'total_desc' => $query->orderBy('total', 'desc'),
            default => $query->latest(),
        };

        $penjualans = $query->paginate(10);

        $summary = [
            'total_penjualan' => PenjualanModel::count(),
            'total_nilai' => PenjualanModel::sum('total'),
            'penjualan_bulan_ini' => PenjualanModel::whereMonth('created_at', now()->month)->count(),
            'piutang_tertanggur' => Piutang::where('status', 'belum')->count(),
        ];

        return view('livewire.pages.dashboard.transaksi.penjualan', [
            'penjualans' => $penjualans,
            'summary' => $summary,
        ])->layout('layouts.dashboard');
    }
}
