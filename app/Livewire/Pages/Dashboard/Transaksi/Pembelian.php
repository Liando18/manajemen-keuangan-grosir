<?php

namespace App\Livewire\Pages\Dashboard\Transaksi;

use App\Models\Pembelian as PembelianModel;
use App\Models\Stok;
use App\Models\Hutang;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class Pembelian extends Component
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
            $pembelian = PembelianModel::with(['pembelianItem', 'hutang'])->find($id);

            if (!$pembelian) {
                session()->flash('error', 'Pembelian tidak ditemukan');
                return;
            }

            foreach ($pembelian->pembelianItem as $item) {
                $stok = Stok::where('barang_id', $item->barang_id)->first();
                if ($stok) {
                    $stok->jumlah -= $item->jumlah;
                    if ($stok->jumlah < 0) {
                        $stok->jumlah = 0;
                    }
                    $stok->save();
                }
            }

            if ($pembelian->hutang) {
                $pembelian->hutang->delete();
            }

            if ($pembelian->bukti) {
                \Storage::disk('public')->delete($pembelian->bukti);
            }

            $pembelian->delete();
            session()->flash('success', 'Pembelian berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus pembelian: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = PembelianModel::with(['supplier', 'hutang']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('bukti', 'like', '%' . $this->search . '%')
                    ->orWhereHas('supplier', function ($subQ) {
                        $subQ->where('nama', 'like', '%' . $this->search . '%');
                    });
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

        $pembelians = $query->paginate(10);

        // $pembelians->each(function ($pembelian) {
        //     $pembelian->hutang_status = $pembelian->hutang?->status ?? 'lunas';
        // });

        $summary = [
            'total_pembelian' => PembelianModel::count(),
            'total_nilai' => PembelianModel::sum('total'),
            'pembelian_bulan_ini' => PembelianModel::whereMonth('created_at', now()->month)->count(),
            'hutang_tertanggur' => Hutang::where('status', 'belum')->count(),
        ];

        return view('livewire.pages.dashboard.transaksi.pembelian', [
            'pembelians' => $pembelians,
            'summary' => $summary,
        ])->layout('layouts.dashboard');
    }
}
