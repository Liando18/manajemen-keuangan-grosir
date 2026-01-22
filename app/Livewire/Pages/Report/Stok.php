<?php

namespace App\Livewire\Pages\Report;

use App\Models\Barang;
use App\Models\Stok as StokModel;
use Livewire\Component;

class Stok extends Component
{
    public $status = '';

    public $laporan = [];

    public function mount()
    {
        $this->status = request()->get('status', '');
        $this->generateLaporan();
    }

    public function generateLaporan()
    {
        $barangs = Barang::with('kategori', 'satuan')->get();
        $laporan = [];
        $no = 1;

        foreach ($barangs as $barang) {
            $stok = StokModel::where('barang_id', $barang->id)->first();
            $jumlahStok = $stok ? $stok->jumlah : 0;

            if ($jumlahStok == 0) {
                $statusText = $stok ? 'Habis' : 'Barang Belum Masuk';
            } else {
                $statusText = 'Tersedia';
            }

            if ($this->status && $this->status !== $statusText) {
                continue;
            }

            $laporan[] = [
                'no' => $no++,
                'kategori' => $barang->kategori->nama ?? '-',
                'barang_nama' => $barang->nama,
                'satuan' => $barang->satuan->nama ?? '-',
                'harga' => $barang->harga,
                'stok' => $jumlahStok,
                'status' => $statusText,
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
        return view('livewire.pages.report.stok', [
            'formatRupiah' => fn($amount) => $this->formatRupiah($amount),
        ])->layout('layouts.report');
    }
}
