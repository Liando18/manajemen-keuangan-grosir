<?php

use App\Livewire\Pages\Auth\Login;
use App\Livewire\Pages\Auth\LupaPassword;
use App\Livewire\Pages\Dashboard\Home;
use App\Livewire\Pages\Dashboard\Keuangan\HutangPiutang;
use App\Livewire\Pages\Dashboard\Keuangan\Pendapatan;
use App\Livewire\Pages\Dashboard\Keuangan\Pengeluaran;
use App\Livewire\Pages\Dashboard\Laporan\HutangPiutang as LaporanHutangPiutang;
use App\Livewire\Pages\Dashboard\Laporan\LabaRugi;
use App\Livewire\Pages\Dashboard\Laporan\Pendapatan as LaporanPendapatan;
use App\Livewire\Pages\Dashboard\Laporan\Pengeluaran as LaporanPengeluaran;
use App\Livewire\Pages\Dashboard\Laporan\Stok;
use App\Livewire\Pages\Dashboard\MasterData\DataAkun;
use App\Livewire\Pages\Dashboard\MasterData\DataBarang;
use App\Livewire\Pages\Dashboard\MasterData\DataKategoriBarang;
use App\Livewire\Pages\Dashboard\MasterData\DataSatuan;
use App\Livewire\Pages\Dashboard\MasterData\DataStok;
use App\Livewire\Pages\Dashboard\MasterData\DataSupplier;
use App\Livewire\Pages\Dashboard\Transaksi\Pembelian;
use App\Livewire\Pages\Dashboard\Transaksi\PembelianDetail;
use App\Livewire\Pages\Dashboard\Transaksi\PembelianInput;
use App\Livewire\Pages\Dashboard\Transaksi\Penjualan;
use App\Livewire\Pages\Dashboard\Transaksi\PenjualanDetail;
use App\Livewire\Pages\Dashboard\Transaksi\PenjualanInput;
use App\Livewire\Pages\Report\CetakHutangPiutang;
use App\Livewire\Pages\Report\CetakLabaRugi;
use App\Livewire\Pages\Report\CetakPendapatan;
use App\Livewire\Pages\Report\CetakPengeluaran;
use App\Livewire\Pages\Report\Stok as ReportStok;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/auth/login', Login::class)->name('login');
Route::get('/auth/lupa-password', LupaPassword::class)->name('lupa-password');

Route::middleware('auth:web')->group(function () {
    Route::get('/', Home::class)->name('home');

    Route::middleware('role:admin')->group(function () {
        Route::get('/master-data/data-akun', DataAkun::class)->name('data-akun');
        Route::get('/master-data/data-kategori-barang', DataKategoriBarang::class)->name('data-kategori-barang');
        Route::get('/master-data/data-satuan', DataSatuan::class)->name('data-satuan');
        Route::get('/master-data/data-barang', DataBarang::class)->name('data-barang');
        Route::get('/master-data/data-supplier', DataSupplier::class)->name('data-supplier');
    });

    Route::middleware('role:admin,pemilik,bendahara')->group(function () {
        Route::get('/laporan/laba-rugi', LabaRugi::class)->name('laporan.laba-rugi');
        Route::get('/laporan/pendapatan', LaporanPendapatan::class)->name('laporan.pendapatan');
        Route::get('/laporan/pengeluaran', LaporanPengeluaran::class)->name('laporan.pengeluaran');
        Route::get('/laporan/hutang-piutang', LaporanHutangPiutang::class)->name('laporan.hutang-piutang');
        Route::get('/laporan/stok', Stok::class)->name('laporan.stok');


        Route::get('/laporan/laba-rugi/cetak', CetakLabaRugi::class)->name('laporan.laba-rugi.cetak');
        Route::get('/laporan/pendapatan/cetak', CetakPendapatan::class)->name('laporan.pendapatan.cetak');
        Route::get('/laporan/pengeluaran/cetak', CetakPengeluaran::class)->name('laporan.pengeluaran.cetak');
        Route::get('/laporan/hutang-piutang/cetak', CetakHutangPiutang::class)->name('laporan.hutang-piutang.cetak');
        Route::get('/laporan/stok/cetak', ReportStok::class)->name('laporan.stok.cetak');
    });

    Route::middleware('role:admin,bendahara')->group(function () {
        Route::get('/keuangan/pendapatan', Pendapatan::class)->name('pendapatan');
        Route::get('/keuangan/pengeluaran', Pengeluaran::class)->name('pengeluaran');
        Route::get('/keuangan/hutang-piutang', HutangPiutang::class)->name('hutang-piutang');
    });

    Route::middleware('role:admin,kasir')->group(function () {
        Route::get('/transaksi/penjualan', Penjualan::class)->name('penjualan');
        Route::get('/transaksi/penjualan/input', PenjualanInput::class)->name('penjualan-input');
        Route::get('/transaksi/penjualan/{id}', PenjualanDetail::class)->name('penjualan-detail');
    });

    Route::middleware('role:admin,gudang')->group(function () {
        Route::get('/transaksi/pembelian', Pembelian::class)->name('pembelian');
        Route::get('/transaksi/pembelian/input', PembelianInput::class)->name('pembelian-input');
        Route::get('/transaksi/pembelian/{id}', PembelianDetail::class)->name('pembelian-detail');
    });

    Route::middleware('role:admin,gudang,kasir')->group(function () {
        Route::get('/master-data/data-stok', DataStok::class)->name('data-stok');
    });
});

Route::get('/logout', function () {
    Auth::guard('web')->logout();
    session()->invalidate();
    return redirect()->route('login');
})->name('logout')->middleware('auth:web');
