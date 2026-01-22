<?php

namespace App\Livewire\Pages\Report;

use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use Livewire\Component;

class CetakLabaRugi extends Component
{
    public $filterType = 'hari';
    public $tanggal = '';
    public $bulan = '';
    public $tahun = '';
    public $tahunFilter = '';

    public $laporan = [];
    public $totalPendapatan = 0;
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

        // PENJUALAN
        $penjualans = Penjualan::with('penjualanItem.barang.satuan')
            ->whereDate('created_at', $date)
            ->get();

        foreach ($penjualans as $penjualan) {
            $items = [];
            foreach ($penjualan->penjualanItem as $item) {
                $items[] = [
                    'barang_nama' => $item->barang->nama,
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->barang->satuan->nama ?? $item->barang->satuan->singkatan ?? '',
                    'harga' => $item->barang->harga,
                ];
            }

            $data[] = [
                'no' => $no++,
                'waktu' => $penjualan->created_at->format('H:i:s'),
                'sumber' => 'Penjualan Barang',
                'items' => $items,
                'jumlah' => $penjualan->total,
                'tipe' => 'pendapatan',
            ];
        }

        // PEMBELIAN
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
                'tipe' => 'pengeluaran',
            ];
        }

        // PENDAPATAN LAINNYA (exclude yang berasal dari Penjualan/Pembelian)
        $pendapatans = Pendapatan::whereDate('created_at', $date)
            ->whereNotIn('sumber', ['Penjualan Barang', 'Pembelian Barang'])
            ->get();
        foreach ($pendapatans as $pendapatan) {
            $data[] = [
                'no' => $no++,
                'waktu' => $pendapatan->created_at->format('H:i:s'),
                'sumber' => $pendapatan->sumber,
                'items' => [],
                'keterangan' => $pendapatan->keterangan ?? '-',
                'jumlah' => $pendapatan->jumlah,
                'tipe' => 'pendapatan',
            ];
        }

        // PENGELUARAN LAINNYA (exclude yang berasal dari Penjualan/Pembelian)
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
                'tipe' => 'pengeluaran',
            ];
        }

        // Sorting by time
        usort($data, function ($a, $b) {
            return strtotime($a['waktu']) - strtotime($b['waktu']);
        });

        // Re-number after sorting
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
                $weeks[$weekKey] = [
                    'pendapatan' => 0,
                    'pengeluaran' => 0,
                ];
            }

            $dayPendapatan = Penjualan::whereDate('created_at', $date->toDateString())->sum('total');
            $dayPendapatan += Pembelian::whereDate('created_at', $date->toDateString())->sum('total');
            $dayPendapatan += Pendapatan::whereDate('created_at', $date->toDateString())
                ->whereNotIn('sumber', ['Penjualan Barang', 'Pembelian Barang'])
                ->sum('jumlah');

            $dayPengeluaran = Pengeluaran::whereDate('created_at', $date->toDateString())
                ->whereNotIn('sumber', ['Penjualan Barang', 'Pembelian Barang'])
                ->sum('jumlah');

            $weeks[$weekKey]['pendapatan'] += $dayPendapatan;
            $weeks[$weekKey]['pengeluaran'] += $dayPengeluaran;
        }

        foreach ($weeks as $week => $values) {
            $bersih = $values['pendapatan'] - $values['pengeluaran'];
            $data[] = [
                'no' => $no++,
                'periode' => $week,
                'pendapatan' => $values['pendapatan'],
                'pengeluaran' => $values['pengeluaran'],
                'bersih' => $bersih,
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

            $pendapatan = Penjualan::whereBetween('created_at', [$startDate, $endDate])->sum('total');
            $pendapatan += Pembelian::whereBetween('created_at', [$startDate, $endDate])->sum('total');
            $pendapatan += Pendapatan::whereBetween('created_at', [$startDate, $endDate])
                ->whereNotIn('sumber', ['Penjualan Barang', 'Pembelian Barang'])
                ->sum('jumlah');

            $pengeluaran = Pengeluaran::whereBetween('created_at', [$startDate, $endDate])
                ->whereNotIn('sumber', ['Penjualan Barang', 'Pembelian Barang'])
                ->sum('jumlah');

            $bersih = $pendapatan - $pengeluaran;

            $data[] = [
                'no' => $no++,
                'bulan' => $bulanNames[str_pad($month, 2, '0', STR_PAD_LEFT)],
                'pendapatan' => $pendapatan,
                'pengeluaran' => $pengeluaran,
                'bersih' => $bersih,
            ];
        }

        $this->laporan = $data;
        $this->calculateTotalsTahunan();
    }

    public function calculateTotals()
    {
        $this->totalPendapatan = collect($this->laporan)
            ->where('tipe', 'pendapatan')
            ->sum('jumlah');

        $this->totalPengeluaran = collect($this->laporan)
            ->where('tipe', 'pengeluaran')
            ->sum('jumlah');
    }

    public function calculateTotalsBulanan()
    {
        $this->totalPendapatan = collect($this->laporan)->sum('pendapatan');
        $this->totalPengeluaran = collect($this->laporan)->sum('pengeluaran');
    }

    public function calculateTotalsTahunan()
    {
        $this->totalPendapatan = collect($this->laporan)->sum('pendapatan');
        $this->totalPengeluaran = collect($this->laporan)->sum('pengeluaran');
    }

    public function formatRupiah($amount)
    {
        return number_format($amount, 0, ',', '.');
    }

    public function render()
    {
        return view('livewire.pages.report.cetak-laba-rugi', [
            'formatRupiah' => fn($amount) => $this->formatRupiah($amount),
        ])->layout('layouts.report');
    }
}
