<?php

namespace App\Livewire\Pages\Report;

use App\Models\Pembelian;
use App\Models\Pengeluaran;
use Livewire\Component;

class CetakPengeluaran extends Component
{
    public $filterType = 'hari';
    public $tanggal = '';
    public $bulan = '';
    public $tahun = '';
    public $tahunFilter = '';

    public $laporan = [];
    public $totalPengeluaran = 0;

    public function mount()
    {
        $this->filterType = request()->get('type', 'hari');
        $this->tanggal = request()->get('tanggal', now()->format('Y-m-d'));
        $this->bulan = request()->get('bulan', now()->format('m'));
        $this->tahun = request()->get('tahun', now()->format('Y'));
        $this->tahunFilter = request()->get('tahunFilter', now()->format('Y'));

        $this->generateLaporan();
    }

    public function generateLaporan()
    {
        match ($this->filterType) {
            'hari' => $this->laporanHarian(),
            'bulan' => $this->laporanBulanan(),
            'tahun' => $this->laporanTahunan(),
        };
    }

    public function laporanHarian()
    {
        $date = \Carbon\Carbon::parse($this->tanggal)->toDateString();
        $data = [];
        $no = 1;

        $pembelians = Pembelian::with('pembelianItem.barang.satuan')
            ->whereDate('created_at', $date)
            ->get();

        foreach ($pembelians as $pembelian) {
            $items = [];
            foreach ($pembelian->pembelianItem as $item) {
                $items[] = [
                    'barang_nama' => $item->barang->nama,
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->barang->satuan->nama ?? $item->barang->satuan->singkatan ?? '',
                    'harga' => $item->harga,
                ];
            }

            $data[] = [
                'no' => $no++,
                'waktu' => $pembelian->created_at->format('H:i:s'),
                'sumber' => 'Pembelian Barang',
                'items' => $items,
                'jumlah' => $pembelian->total,
            ];
        }

        $pengeluarans = Pengeluaran::whereDate('created_at', $date)
            ->whereNotIn('sumber', ['Penjualan Barang', 'Pembelian Barang'])
            ->get();
        foreach ($pengeluarans as $pengeluaran) {
            $data[] = [
                'no' => $no++,
                'waktu' => $pengeluaran->created_at->format('H:i:s'),
                'sumber' => $pengeluaran->sumber,
                'items' => [],
                'keterangan' => $pengeluaran->keterangan ?? '-',
                'jumlah' => $pengeluaran->jumlah,
            ];
        }

        usort($data, function ($a, $b) {
            return strtotime($a['waktu']) - strtotime($b['waktu']);
        });

        $no = 1;
        foreach ($data as &$item) {
            $item['no'] = $no++;
        }

        $this->laporan = $data;
        $this->calculateTotals();
    }

    public function laporanBulanan()
    {
        $startDate = \Carbon\Carbon::createFromFormat('Y-m', $this->tahun . '-' . $this->bulan)->startOfMonth();
        $endDate = $startDate->clone()->endOfMonth();

        $data = [];
        $no = 1;
        $weeks = [];

        for ($date = $startDate->clone(); $date <= $endDate; $date->addDay()) {
            $weekNumber = ceil($date->day / 7);
            $weekKey = 'Minggu Ke-' . $weekNumber;

            if (!isset($weeks[$weekKey])) {
                $weeks[$weekKey] = 0;
            }

            $dayPengeluaran = Pembelian::whereDate('created_at', $date->toDateString())->sum('total');
            $dayPengeluaran += Pengeluaran::whereDate('created_at', $date->toDateString())
                ->whereNotIn('sumber', ['Penjualan Barang', 'Pembelian Barang'])
                ->sum('jumlah');

            $weeks[$weekKey] += $dayPengeluaran;
        }

        foreach ($weeks as $week => $total) {
            $data[] = [
                'no' => $no++,
                'periode' => $week,
                'jumlah' => $total,
            ];
        }

        $this->laporan = $data;
        $this->calculateTotalsBulanan();
    }

    public function laporanTahunan()
    {
        $data = [];
        $no = 1;
        $bulanNames = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        for ($month = 1; $month <= 12; $month++) {
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $this->tahunFilter . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01')->startOfMonth();
            $endDate = $startDate->clone()->endOfMonth();

            $total = Pembelian::whereBetween('created_at', [$startDate, $endDate])->sum('total');
            $total += Pengeluaran::whereBetween('created_at', [$startDate, $endDate])
                ->whereNotIn('sumber', ['Penjualan Barang', 'Pembelian Barang'])
                ->sum('jumlah');

            $data[] = [
                'no' => $no++,
                'bulan' => $bulanNames[str_pad($month, 2, '0', STR_PAD_LEFT)],
                'jumlah' => $total,
            ];
        }

        $this->laporan = $data;
        $this->calculateTotalsTahunan();
    }

    public function calculateTotals()
    {
        $this->totalPengeluaran = collect($this->laporan)->sum('jumlah');
    }

    public function calculateTotalsBulanan()
    {
        $this->totalPengeluaran = collect($this->laporan)->sum('jumlah');
    }

    public function calculateTotalsTahunan()
    {
        $this->totalPengeluaran = collect($this->laporan)->sum('jumlah');
    }

    public function formatRupiah($amount)
    {
        return number_format($amount, 0, ',', '.');
    }

    public function render()
    {
        return view('livewire.pages.report.cetak-pengeluaran', [
            'formatRupiah' => fn($amount) => $this->formatRupiah($amount),
        ])->layout('layouts.report');
    }
}
