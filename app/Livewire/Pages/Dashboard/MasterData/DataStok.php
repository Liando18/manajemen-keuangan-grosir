<?php

namespace App\Livewire\Pages\Dashboard\MasterData;

use App\Models\Barang;
use App\Models\Stok;
use Livewire\Component;
use Livewire\WithPagination;

class DataStok extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Barang::with(['kategori', 'stok']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhereHas('kategori', function ($subQ) {
                        $subQ->where('nama', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->filterStatus === 'tersedia') {
            $query->whereHas('stok', function ($q) {
                $q->where('jumlah', '>', 10);
            });
        } elseif ($this->filterStatus === 'rendah') {
            $query->whereHas('stok', function ($q) {
                $q->where('jumlah', '>', 0)->where('jumlah', '<=', 10);
            });
        } elseif ($this->filterStatus === 'habis') {
            $query->where(function ($q) {
                $q->whereHas('stok', function ($sq) {
                    $sq->where('jumlah', 0);
                })->orDoesntHave('stok');
            });
        }

        $barangs = $query->paginate(10);

        $stoksData = $barangs->map(function ($barang) {
            return [
                'id' => $barang->id,
                'nama' => $barang->nama,
                'kategori' => $barang->kategori->nama,
                'jumlah' => $barang->stok ? $barang->stok->jumlah : 0,
            ];
        });

        $allStoks = Stok::with('barang')->get();
        $allBarangs = Barang::all();

        $totalStok = $allStoks->sum('jumlah');
        $stokHabis = $allStoks->where('jumlah', 0)->count() + ($allBarangs->count() - $allStoks->count());
        $stokRendah = $allStoks->where('jumlah', '>', 0)->where('jumlah', '<=', 10)->count();
        $stokTersedia = $allStoks->where('jumlah', '>', 10)->count();

        return view('livewire.pages.dashboard.master-data.data-stok', [
            'stoks' => $stoksData,
            'paginator' => $barangs,
            'totalStok' => $totalStok,
            'stokHabis' => $stokHabis,
            'stokRendah' => $stokRendah,
            'stokTersedia' => $stokTersedia,
        ])->layout('layouts.dashboard');
    }
}
