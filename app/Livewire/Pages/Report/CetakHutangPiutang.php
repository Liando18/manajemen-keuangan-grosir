<?php

namespace App\Livewire\Pages\Report;

use App\Models\Hutang;
use App\Models\Piutang;
use Livewire\Component;

class CetakHutangPiutang extends Component
{
    public $jenis = '';
    public $status = '';

    public $laporan = [];

    public function mount()
    {
        $this->jenis = request()->get('jenis', '');
        $this->status = request()->get('status', '');

        $this->generateLaporan();
    }

    public function generateLaporan()
    {
        if ($this->jenis === 'hutang') {
            $this->laporanHutang();
        } elseif ($this->jenis === 'piutang') {
            $this->laporanPiutang();
        } else {
            $this->laporanSemua();
        }
    }

    public function laporanHutang()
    {
        $query = Hutang::with('pembelian', 'supplier');

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $data = $query->get();
        $laporan = [];
        $no = 1;

        foreach ($data as $hutang) {
            $total = $hutang->pembelian->total ?? 0;
            $sisa = $total - $hutang->terbayar;

            $laporan[] = [
                'no' => $no++,
                'jenis' => 'Hutang',
                'nama' => $hutang->supplier->nama ?? '-',
                'total' => $total,
                'terbayar' => $hutang->terbayar,
                'sisa' => $sisa,
                'status' => $hutang->status,
            ];
        }

        $this->laporan = $laporan;
    }

    public function laporanPiutang()
    {
        $query = Piutang::with('penjualan');

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $data = $query->get();
        $laporan = [];
        $no = 1;

        foreach ($data as $piutang) {
            $total = $piutang->penjualan->total ?? 0;
            $sisa = $total - $piutang->terbayar;

            $laporan[] = [
                'no' => $no++,
                'jenis' => 'Piutang',
                'nama' => $piutang->nama,
                'total' => $total,
                'terbayar' => $piutang->terbayar,
                'sisa' => $sisa,
                'status' => $piutang->status,
            ];
        }

        $this->laporan = $laporan;
    }

    public function laporanSemua()
    {
        $laporan = [];
        $no = 1;

        $hutangQuery = Hutang::with('pembelian', 'supplier');
        if ($this->status) {
            $hutangQuery->where('status', $this->status);
        }
        $hutangs = $hutangQuery->get();

        foreach ($hutangs as $hutang) {
            $total = $hutang->pembelian->total ?? 0;
            $sisa = $total - $hutang->terbayar;

            $laporan[] = [
                'no' => $no++,
                'jenis' => 'Hutang',
                'nama' => $hutang->supplier->nama ?? '-',
                'total' => $total,
                'terbayar' => $hutang->terbayar,
                'sisa' => $sisa,
                'status' => $hutang->status,
            ];
        }

        $piutangQuery = Piutang::with('penjualan');
        if ($this->status) {
            $piutangQuery->where('status', $this->status);
        }
        $piutangs = $piutangQuery->get();

        foreach ($piutangs as $piutang) {
            $total = $piutang->penjualan->total ?? 0;
            $sisa = $total - $piutang->terbayar;

            $laporan[] = [
                'no' => $no++,
                'jenis' => 'Piutang',
                'nama' => $piutang->nama,
                'total' => $total,
                'terbayar' => $piutang->terbayar,
                'sisa' => $sisa,
                'status' => $piutang->status,
            ];
        }

        $this->laporan = $laporan;
    }

    public function formatRupiah($amount)
    {
        return number_format($amount, 0, ',', '.');
    }

    public function render()
    {
        return view('livewire.pages.report.cetak-hutang-piutang', [
            'formatRupiah' => fn($amount) => $this->formatRupiah($amount),
        ])->layout('layouts.report');
    }
}
