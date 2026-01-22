<?php

namespace App\Livewire\Pages\Dashboard;

use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use App\Models\Hutang;
use App\Models\Piutang;
use App\Models\Stok;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{
    public $totalPendapatan = 0;
    public $totalPengeluaran = 0;
    public $totalHutang = 0;
    public $totalPiutang = 0;
    public $transaksiHariIni = 0;
    public $recentTransactions = [];
    public $totalPenjualan = 0;
    public $totalPembelian = 0;
    public $stokMenipis = 0;
    public $userRole;

    public function mount()
    {
        $this->userRole = Auth::user()->role;
        $this->calculateStats();
        $this->getRecentTransactions();
    }

    public function calculateStats()
    {
        $bulanIni = now()->startOfMonth();
        $hariIni = now()->startOfDay();

        if (in_array($this->userRole, ['admin', 'pemilik', 'bendahara'])) {
            $this->totalPendapatan = Pendapatan::where('created_at', '>=', $bulanIni)->sum('jumlah');
            $this->totalPengeluaran = Pengeluaran::where('created_at', '>=', $bulanIni)->sum('jumlah');

            $hutangs = Hutang::with('pembelian')->where('status', 'belum')->get();
            $this->totalHutang = $hutangs->sum(function ($hutang) {
                return $hutang->pembelian->total - $hutang->terbayar;
            });

            $piutangs = Piutang::with('penjualan')->where('status', 'belum')->get();
            $this->totalPiutang = $piutangs->sum(function ($piutang) {
                return $piutang->penjualan->total - $piutang->terbayar;
            });
        }

        if (in_array($this->userRole, ['admin', 'kasir'])) {
            $this->totalPenjualan = Penjualan::where('created_at', '>=', $bulanIni)->count();
            $this->transaksiHariIni = Penjualan::where('created_at', '>=', $hariIni)->count();
        }

        if (in_array($this->userRole, ['admin', 'gudang'])) {
            $this->totalPembelian = Pembelian::where('created_at', '>=', $bulanIni)->count();
            $this->stokMenipis = Stok::where('jumlah', '<=', 10)->count();

            if ($this->userRole === 'gudang') {
                $this->transaksiHariIni = Pembelian::where('created_at', '>=', $hariIni)->count();
            }
        }

        if ($this->userRole === 'admin') {
            $penjualanHariIni = Penjualan::where('created_at', '>=', $hariIni)->count();
            $pembelianHariIni = Pembelian::where('created_at', '>=', $hariIni)->count();
            $this->transaksiHariIni = $penjualanHariIni + $pembelianHariIni;
        }
    }

    public function formatRupiah($amount)
    {
        if ($amount >= 1000000000) {
            return number_format($amount / 1000000000, 1, ',', '.') . ' M';
        } elseif ($amount >= 1000000) {
            return number_format($amount / 1000000, 1, ',', '.') . ' JT';
        } elseif ($amount >= 1000) {
            return number_format($amount / 1000, 1, ',', '.') . ' RB';
        } else {
            return number_format($amount, 0, ',', '.');
        }
    }

    public function getRecentTransactions()
    {
        $transactions = collect();

        if (in_array($this->userRole, ['admin', 'kasir'])) {
            $penjualan = Penjualan::with('penjualanItem')
                ->latest()
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'type' => 'penjualan',
                        'deskripsi' => 'Penjualan Barang',
                        'kategori' => 'Pemasukan',
                        'tanggal' => $item->created_at->format('d M Y, H:i'),
                        'nominal' => $item->total,
                        'nominal_format' => $this->formatRupiah($item->total),
                        'icon' => 'arrow-up',
                        'icon_bg' => 'bg-green-100',
                        'icon_color' => 'text-green-600',
                    ];
                });
            $transactions = $transactions->merge($penjualan);
        }

        if (in_array($this->userRole, ['admin', 'gudang'])) {
            $pembelian = Pembelian::with('pembelianItem')
                ->latest()
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'type' => 'pembelian',
                        'deskripsi' => 'Pembelian Barang',
                        'kategori' => 'Pengeluaran',
                        'tanggal' => $item->created_at->format('d M Y, H:i'),
                        'nominal' => $item->total,
                        'nominal_format' => $this->formatRupiah($item->total),
                        'icon' => 'arrow-down',
                        'icon_bg' => 'bg-red-100',
                        'icon_color' => 'text-red-600',
                    ];
                });
            $transactions = $transactions->merge($pembelian);
        }

        if (in_array($this->userRole, ['admin', 'bendahara'])) {
            $pendapatan = Pendapatan::latest()
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'type' => 'pendapatan',
                        'deskripsi' => $item->sumber,
                        'kategori' => 'Pemasukan',
                        'tanggal' => $item->created_at->format('d M Y, H:i'),
                        'nominal' => $item->jumlah,
                        'nominal_format' => $this->formatRupiah($item->jumlah),
                        'icon' => 'arrow-up',
                        'icon_bg' => 'bg-green-100',
                        'icon_color' => 'text-green-600',
                    ];
                });
            $transactions = $transactions->merge($pendapatan);

            $pengeluaran = Pengeluaran::latest()
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'type' => 'pengeluaran',
                        'deskripsi' => $item->sumber,
                        'kategori' => 'Pengeluaran',
                        'tanggal' => $item->created_at->format('d M Y, H:i'),
                        'nominal' => $item->jumlah,
                        'nominal_format' => $this->formatRupiah($item->jumlah),
                        'icon' => 'arrow-down',
                        'icon_bg' => 'bg-red-100',
                        'icon_color' => 'text-red-600',
                    ];
                });
            $transactions = $transactions->merge($pengeluaran);
        }

        $this->recentTransactions = $transactions
            ->sortByDesc('tanggal')
            ->take(10)
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.pages.dashboard.home', [
            'formatRupiah' => fn($amount) => $this->formatRupiah($amount),
        ])->layout('layouts.dashboard');
    }
}
