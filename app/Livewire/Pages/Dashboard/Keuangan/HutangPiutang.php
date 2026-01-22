<?php

namespace App\Livewire\Pages\Dashboard\Keuangan;

use App\Models\Hutang;
use App\Models\Piutang;
use App\Models\Pembelian;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class HutangPiutang extends Component
{
    use WithPagination;

    public $searchHutang = '';
    public $searchPiutang = '';
    public $statusFilterHutang = '';
    public $statusFilterPiutang = '';

    public $showModalHutang = false;
    public $showModalPiutang = false;
    public $editingHutangId = null;
    public $editingPiutangId = null;

    #[Validate('required|numeric|min:0')]
    public $bayarHutangNominal = '';

    #[Validate('required|numeric|min:0')]
    public $bayarPiutangNominal = '';

    public $hutangTotal = 0;
    public $piutangTotal = 0;

    protected $messages = [
        'bayarHutangNominal.required' => 'Jumlah bayar harus diisi',
        'bayarHutangNominal.numeric' => 'Jumlah harus berupa angka',
        'bayarHutangNominal.min' => 'Jumlah tidak boleh negatif',
        'bayarPiutangNominal.required' => 'Jumlah bayar harus diisi',
        'bayarPiutangNominal.numeric' => 'Jumlah harus berupa angka',
        'bayarPiutangNominal.min' => 'Jumlah tidak boleh negatif',
    ];

    public function editHutang($id)
    {
        $hutang = Hutang::find($id);

        if (!$hutang) {
            session()->flash('error', 'Data hutang tidak ditemukan');
            return;
        }

        $this->editingHutangId = $id;
        $this->hutangTotal = $hutang->terbayar;
        $this->bayarHutangNominal = '';
        $this->showModalHutang = true;
    }

    public function editPiutang($id)
    {
        $piutang = Piutang::find($id);

        if (!$piutang) {
            session()->flash('error', 'Data piutang tidak ditemukan');
            return;
        }

        $this->editingPiutangId = $id;
        $this->piutangTotal = $piutang->terbayar;
        $this->bayarPiutangNominal = '';
        $this->showModalPiutang = true;
    }

    public function saveHutang()
    {
        $this->validate([
            'bayarHutangNominal' => 'required|numeric|min:0',
        ]);

        try {
            $hutang = Hutang::find($this->editingHutangId);

            if (!$hutang) {
                session()->flash('error', 'Data hutang tidak ditemukan');
                return;
            }

            $totalBayar = $hutang->terbayar + floatval($this->bayarHutangNominal);
            $pembelian = $hutang->pembelian;

            if ($totalBayar >= $pembelian->total) {
                $hutang->update([
                    'terbayar' => $pembelian->total,
                    'status' => 'lunas',
                ]);
                session()->flash('success', 'Hutang lunas!');
            } else {
                $hutang->update([
                    'terbayar' => $totalBayar,
                    'status' => 'belum',
                ]);
                session()->flash('success', 'Pembayaran hutang berhasil dicatat');
            }

            $this->closeModalHutang();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function savePiutang()
    {
        $this->validate([
            'bayarPiutangNominal' => 'required|numeric|min:0',
        ]);

        try {
            $piutang = Piutang::find($this->editingPiutangId);

            if (!$piutang) {
                session()->flash('error', 'Data piutang tidak ditemukan');
                return;
            }

            $penjualan = $piutang->penjualan;
            $totalBayar = $piutang->terbayar + floatval($this->bayarPiutangNominal);

            if ($totalBayar >= $penjualan->total) {
                $piutang->update([
                    'terbayar' => $penjualan->total,
                    'status' => 'lunas',
                ]);
                session()->flash('success', 'Piutang lunas!');
            } else {
                $piutang->update([
                    'terbayar' => $totalBayar,
                    'status' => 'belum',
                ]);
                session()->flash('success', 'Penerimaan piutang berhasil dicatat');
            }

            $this->closeModalPiutang();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteHutang($id)
    {
        try {
            $hutang = Hutang::find($id);

            if (!$hutang) {
                session()->flash('error', 'Data hutang tidak ditemukan');
                return;
            }

            $hutang->delete();
            session()->flash('success', 'Hutang berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deletePiutang($id)
    {
        try {
            $piutang = Piutang::find($id);

            if (!$piutang) {
                session()->flash('error', 'Data piutang tidak ditemukan');
                return;
            }

            $piutang->delete();
            session()->flash('success', 'Piutang berhasil dihapus');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function closeModalHutang()
    {
        $this->showModalHutang = false;
        $this->editingHutangId = null;
        $this->bayarHutangNominal = '';
        $this->hutangTotal = 0;
        $this->resetErrorBag();
    }

    public function closeModalPiutang()
    {
        $this->showModalPiutang = false;
        $this->editingPiutangId = null;
        $this->bayarPiutangNominal = '';
        $this->piutangTotal = 0;
        $this->resetErrorBag();
    }

    public function render()
    {
        $hutangs = Hutang::with(['pembelian', 'supplier'])
            ->when($this->searchHutang, function ($query) {
                $query->whereHas('supplier', function ($q) {
                    $q->where('nama', 'like', '%' . $this->searchHutang . '%');
                });
            })
            ->when($this->statusFilterHutang, function ($query) {
                $query->where('status', $this->statusFilterHutang);
            })
            ->latest()
            ->paginate(10, ['*'], 'hutang_page');

        $piutangs = Piutang::with('penjualan')
            ->when($this->searchPiutang, function ($query) {
                $query->where('nama', 'like', '%' . $this->searchPiutang . '%');
            })
            ->when($this->statusFilterPiutang, function ($query) {
                $query->where('status', $this->statusFilterPiutang);
            })
            ->latest()
            ->paginate(10, ['*'], 'piutang_page');

        $hutangBelum = 0;
        $totalHutang = 0;

        foreach ($hutangs as $item) {
            $sisa = $item->pembelian->total - $item->terbayar;
            if ($item->status === 'belum') {
                $totalHutang += $item->pembelian->total;
                $hutangBelum += $sisa;
            }
        }

        $piutangBelum = 0;
        $totalPiutang = 0;

        foreach ($piutangs as $item) {
            $sisa = $item->penjualan->total - $item->terbayar;
            $totalPiutang += $item->penjualan->total;
            if ($item->status === 'belum') {
                $piutangBelum += $sisa;
            }
        }

        return view('livewire.pages.dashboard.keuangan.hutang-piutang', [
            'hutangs' => $hutangs,
            'piutangs' => $piutangs,
            'totalHutang' => $totalHutang,
            'hutangBelum' => $hutangBelum,
            'totalPiutang' => $totalPiutang,
            'piutangBelum' => $piutangBelum,
        ])->layout('layouts.dashboard');
    }
}
