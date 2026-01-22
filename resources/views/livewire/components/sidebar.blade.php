<div>
    <aside
        class="w-72 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white fixed left-0 top-0 h-screen overflow-hidden shadow-2xl z-50 lg:z-30 flex flex-col">

        <div class="p-6 border-b border-slate-700 bg-gradient-to-r from-slate-900 to-slate-800">
            <div class="flex items-center space-x-3">
                <div
                    class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-lg transform hover:scale-105 transition">
                    <i class="fas fa-wallet text-2xl text-white"></i>
                </div>
                <div>
                    <h1
                        class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">
                        Grosir Netral</h1>
                    <p class="text-xs text-slate-400 font-medium">Financial Manager</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 overflow-y-auto space-y-1"
            style="scrollbar-width: thin; scrollbar-color: rgba(59, 130, 246, 0.4) transparent;">
            <style>
                nav::-webkit-scrollbar {
                    width: 6px;
                }

                nav::-webkit-scrollbar-track {
                    background: transparent;
                }

                nav::-webkit-scrollbar-thumb {
                    background: rgba(59, 130, 246, 0.4);
                    border-radius: 3px;
                }

                nav::-webkit-scrollbar-thumb:hover {
                    background: rgba(59, 130, 246, 0.6);
                }
            </style>

            <a href="{{ route('home') }}"
                class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('home') ? 'bg-blue-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}"
                data-route="home">
                <div
                    class="p-2 rounded-lg {{ request()->routeIs('home') ? 'bg-blue-600' : 'bg-blue-500/20 group-hover:bg-blue-500/40' }} transition">
                    <i class="fas fa-chart-line {{ request()->routeIs('home') ? 'text-white' : 'text-blue-400' }}"></i>
                </div>
                <span class="font-medium">Dashboard</span>
                <div
                    class="ml-auto w-1 h-6 {{ request()->routeIs('home') ? 'bg-blue-300' : 'bg-blue-500' }} rounded-full {{ request()->routeIs('home') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                </div>
            </a>

            @if (Auth::user()->role === 'admin')
                <div class="pt-4 pb-2 px-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Master Data</p>
                </div>

                <a href="{{ route('data-akun') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('data-akun') ? 'bg-purple-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}"
                    data-route="data-akun">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('data-akun') ? 'bg-purple-600' : 'bg-purple-500/20 group-hover:bg-purple-500/40' }} transition">
                        <i
                            class="fas fa-users {{ request()->routeIs('data-akun') ? 'text-white' : 'text-purple-400' }}"></i>
                    </div>
                    <span class="font-medium">Akun</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('data-akun') ? 'bg-purple-300' : 'bg-purple-500' }} rounded-full {{ request()->routeIs('data-akun') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a>

                <a href="{{ route('data-kategori-barang') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('data-kategori-barang') ? 'bg-indigo-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}"
                    data-route="data-kategori-barang">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('data-kategori-barang') ? 'bg-indigo-600' : 'bg-indigo-500/20 group-hover:bg-indigo-500/40' }} transition">
                        <i
                            class="fas fa-list {{ request()->routeIs('data-kategori-barang') ? 'text-white' : 'text-indigo-400' }}"></i>
                    </div>
                    <span class="font-medium">Kategori Barang</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('data-kategori-barang') ? 'bg-indigo-300' : 'bg-indigo-500' }} rounded-full {{ request()->routeIs('data-kategori-barang') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a>

                <a href="{{ route('data-satuan') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('data-satuan') ? 'bg-indigo-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}"
                    data-route="data-satuan">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('data-satuan') ? 'bg-indigo-600' : 'bg-indigo-500/20 group-hover:bg-indigo-500/40' }} transition">
                        <i
                            class="fas fa-database {{ request()->routeIs('data-satuan') ? 'text-white' : 'text-indigo-400' }}"></i>
                    </div>
                    <span class="font-medium">Satuan Barang</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('data-satuan') ? 'bg-indigo-300' : 'bg-indigo-500' }} rounded-full {{ request()->routeIs('data-satuan') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a>

                <a href="{{ route('data-barang') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('data-barang') ? 'bg-cyan-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}"
                    data-route="data-barang">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('data-barang') ? 'bg-cyan-600' : 'bg-cyan-500/20 group-hover:bg-cyan-500/40' }} transition">
                        <i
                            class="fas fa-box {{ request()->routeIs('data-barang') ? 'text-white' : 'text-cyan-400' }}"></i>
                    </div>
                    <span class="font-medium">Barang</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('data-barang') ? 'bg-cyan-300' : 'bg-cyan-500' }} rounded-full {{ request()->routeIs('data-barang') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a>

                {{-- <a href="{{ route('data-stok') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('data-stok') ? 'bg-teal-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}"
                    data-route="data-stok">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('data-stok') ? 'bg-teal-600' : 'bg-teal-500/20 group-hover:bg-teal-500/40' }} transition">
                        <i
                            class="fas fa-warehouse {{ request()->routeIs('data-stok') ? 'text-white' : 'text-teal-400' }}"></i>
                    </div>
                    <span class="font-medium">Stok</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('data-stok') ? 'bg-teal-300' : 'bg-teal-500' }} rounded-full {{ request()->routeIs('data-stok') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a> --}}

                <a href="{{ route('data-supplier') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('data-supplier') ? 'bg-amber-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}"
                    data-route="data-supplier">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('data-supplier') ? 'bg-amber-600' : 'bg-amber-500/20 group-hover:bg-amber-500/40' }} transition">
                        <i
                            class="fas fa-building {{ request()->routeIs('data-supplier') ? 'text-white' : 'text-amber-400' }}"></i>
                    </div>
                    <span class="font-medium">Supplier</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('data-supplier') ? 'bg-amber-300' : 'bg-amber-500' }} rounded-full {{ request()->routeIs('data-supplier') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a>
            @endif

            @if (in_array(Auth::user()->role, ['admin', 'kasir', 'gudang']))
                <div class="pt-4 pb-2 px-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Transaksi</p>
                </div>

                @if (in_array(Auth::user()->role, ['admin', 'gudang']))
                    <a href="{{ route('pembelian') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('pembelian', 'pembelian-input', 'pembelian-detail') ? 'bg-red-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}"
                        data-route="pembelian">
                        <div
                            class="p-2 rounded-lg {{ request()->routeIs('pembelian', 'pembelian-input', 'pembelian-detail') ? 'bg-red-600' : 'bg-red-500/20 group-hover:bg-red-500/40' }} transition">
                            <i
                                class="fas fa-arrow-down {{ request()->routeIs('pembelian', 'pembelian-input', 'pembelian-detail') ? 'text-white' : 'text-red-400' }}"></i>
                        </div>
                        <span class="font-medium">Pembelian</span>
                        <div
                            class="ml-auto w-1 h-6 {{ request()->routeIs('pembelian', 'pembelian-input', 'pembelian-detail') ? 'bg-red-300' : 'bg-red-500' }} rounded-full {{ request()->routeIs('pembelian', 'pembelian-input', 'pembelian-detail') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                        </div>
                    </a>
                @endif

                @if (in_array(Auth::user()->role, ['admin', 'kasir']))
                    <a href="{{ route('penjualan') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('penjualan', 'penjualan-input', 'penjualan-detail') ? 'bg-green-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}"
                        data-route="penjualan">
                        <div
                            class="p-2 rounded-lg {{ request()->routeIs('penjualan', 'penjualan-input', 'penjualan-detail') ? 'bg-green-600' : 'bg-green-500/20 group-hover:bg-green-500/40' }} transition">
                            <i
                                class="fas fa-arrow-up {{ request()->routeIs('penjualan', 'penjualan-input', 'penjualan-detail') ? 'text-white' : 'text-green-400' }}"></i>
                        </div>
                        <span class="font-medium">Penjualan</span>
                        <div
                            class="ml-auto w-1 h-6 {{ request()->routeIs('penjualan', 'penjualan-input', 'penjualan-detail') ? 'bg-green-300' : 'bg-green-500' }} rounded-full {{ request()->routeIs('penjualan', 'penjualan-input', 'penjualan-detail') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                        </div>
                    </a>
                @endif

                <a href="{{ route('data-stok') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('data-stok') ? 'bg-teal-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}"
                    data-route="data-stok">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('data-stok') ? 'bg-teal-600' : 'bg-teal-500/20 group-hover:bg-teal-500/40' }} transition">
                        <i
                            class="fas fa-warehouse {{ request()->routeIs('data-stok') ? 'text-white' : 'text-teal-400' }}"></i>
                    </div>
                    <span class="font-medium">Cek Stok Barang</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('data-stok') ? 'bg-teal-300' : 'bg-teal-500' }} rounded-full {{ request()->routeIs('data-stok') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a>
            @endif

            @if (in_array(Auth::user()->role, ['admin', 'bendahara']))
                <div class="pt-4 pb-2 px-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Keuangan</p>
                </div>

                <a href="{{ route('pendapatan') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('pendapatan') ? 'bg-emerald-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}"
                    data-route="pendapatan">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('pendapatan') ? 'bg-emerald-600' : 'bg-emerald-500/20 group-hover:bg-emerald-500/40' }} transition">
                        <i
                            class="fas fa-money-bill-wave {{ request()->routeIs('pendapatan') ? 'text-white' : 'text-emerald-400' }}"></i>
                    </div>
                    <span class="font-medium">Pendapatan</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('pendapatan') ? 'bg-emerald-300' : 'bg-emerald-500' }} rounded-full {{ request()->routeIs('pendapatan') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a>

                <a href="{{ route('pengeluaran') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('pengeluaran') ? 'bg-orange-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}"
                    data-route="pengeluaran">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('pengeluaran') ? 'bg-orange-600' : 'bg-orange-500/20 group-hover:bg-orange-500/40' }} transition">
                        <i
                            class="fas fa-credit-card {{ request()->routeIs('pengeluaran') ? 'text-white' : 'text-orange-400' }}"></i>
                    </div>
                    <span class="font-medium">Pengeluaran</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('pengeluaran') ? 'bg-orange-300' : 'bg-orange-500' }} rounded-full {{ request()->routeIs('pengeluaran') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a>

                <a href="{{ route('hutang-piutang') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('hutang-piutang') ? 'bg-pink-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}"
                    data-route="hutang-piutang">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('hutang-piutang') ? 'bg-pink-600' : 'bg-pink-500/20 group-hover:bg-pink-500/40' }} transition">
                        <i
                            class="fas fa-handshake {{ request()->routeIs('hutang-piutang') ? 'text-white' : 'text-pink-400' }}"></i>
                    </div>
                    <span class="font-medium">Hutang & Piutang</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('hutang-piutang') ? 'bg-pink-300' : 'bg-pink-500' }} rounded-full {{ request()->routeIs('hutang-piutang') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a>
            @endif

            @if (in_array(Auth::user()->role, ['admin', 'pemilik', 'bendahara']))
                <div class="pt-4 pb-2 px-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Laporan</p>
                </div>

                <a href="{{ route('laporan.laba-rugi') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('laporan.laba-rugi', 'laporan.laba-rugi.cetak') ? 'bg-rose-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('laporan.laba-rugi', 'laporan.laba-rugi.cetak') ? 'bg-rose-600' : 'bg-rose-500/20 group-hover:bg-rose-500/40' }} transition">
                        <i
                            class="fas fa-chart-pie {{ request()->routeIs('laporan.laba-rugi', 'laporan.laba-rugi.cetak') ? 'text-white' : 'text-rose-400' }}"></i>
                    </div>
                    <span class="font-medium">Laporan Laba/Rugi</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('laporan.laba-rugi', 'laporan.laba-rugi.cetak') ? 'bg-rose-300' : 'bg-rose-500' }} rounded-full {{ request()->routeIs('laporan.laba-rugi', 'laporan.laba-rugi.cetak') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a>

                <a href="{{ route('laporan.pendapatan') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('laporan.pendapatan', 'laporan.pendapatan.cetak') ? 'bg-emerald-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('laporan.pendapatan', 'laporan.pendapatan.cetak') ? 'bg-emerald-600' : 'bg-emerald-500/20 group-hover:bg-emerald-500/40' }} transition">
                        <i
                            class="fas fa-chart-bar {{ request()->routeIs('laporan.pendapatan', 'laporan.pendapatan.cetak') ? 'text-white' : 'text-emerald-400' }}"></i>
                    </div>
                    <span class="font-medium">Laporan Pendapatan</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('laporan.pendapatan', 'laporan.pendapatan.cetak') ? 'bg-emerald-300' : 'bg-emerald-500' }} rounded-full {{ request()->routeIs('laporan.pendapatan', 'laporan.pendapatan.cetak') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a>

                <a href="{{ route('laporan.pengeluaran') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('laporan.pengeluaran', 'laporan.pengeluaran.cetak') ? 'bg-orange-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('laporan.pengeluaran', 'laporan.pengeluaran.cetak') ? 'bg-orange-600' : 'bg-orange-500/20 group-hover:bg-orange-500/40' }} transition">
                        <i
                            class="fas fa-chart-line {{ request()->routeIs('laporan.pengeluaran', 'laporan.pengeluaran.cetak') ? 'text-white' : 'text-orange-400' }}"></i>
                    </div>
                    <span class="font-medium">Laporan Pengeluaran</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('laporan.pengeluaran', 'laporan.pengeluaran.cetak') ? 'bg-orange-300' : 'bg-orange-500' }} rounded-full {{ request()->routeIs('laporan.pengeluaran', 'laporan.pengeluaran.cetak') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a>

                <a href="{{ route('laporan.hutang-piutang') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('laporan.hutang-piutang', 'laporan.hutang-piutang.cetak') ? 'bg-pink-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('laporan.hutang-piutang', 'laporan.hutang-piutang.cetak') ? 'bg-pink-600' : 'bg-pink-500/20 group-hover:bg-pink-500/40' }} transition">
                        <i
                            class="fas fa-handshake {{ request()->routeIs('laporan.hutang-piutang', 'laporan.hutang-piutang.cetak') ? 'text-white' : 'text-pink-400' }}"></i>
                    </div>
                    <span class="font-medium">Laporan Hutang/Piutang</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('laporan.hutang-piutang', 'laporan.hutang-piutang.cetak') ? 'bg-pink-300' : 'bg-pink-500' }} rounded-full {{ request()->routeIs('laporan.hutang-piutang', 'laporan.hutang-piutang.cetak') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a>

                <a href="{{ route('laporan.stok') }}"
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg transition group nav-link {{ request()->routeIs('laporan.stok', 'laporan.stok.cetak') ? 'bg-violet-700 text-white' : 'text-slate-200 hover:bg-slate-700' }}">
                    <div
                        class="p-2 rounded-lg {{ request()->routeIs('laporan.stok', 'laporan.stok.cetak') ? 'bg-violet-600' : 'bg-violet-500/20 group-hover:bg-violet-500/40' }} transition">
                        <i
                            class="fas fa-file-pdf {{ request()->routeIs('laporan.stok', 'laporan.stok.cetak') ? 'text-white' : 'text-violet-400' }}"></i>
                    </div>
                    <span class="font-medium">Laporan Stok Barang</span>
                    <div
                        class="ml-auto w-1 h-6 {{ request()->routeIs('laporan.stok', 'laporan.stok.cetak') ? 'bg-violet-300' : 'bg-violet-500' }} rounded-full {{ request()->routeIs('laporan.stok', 'laporan.stok.cetak') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }} transition">
                    </div>
                </a>
            @endif
        </nav>

        <div class="p-4 border-t border-slate-700 bg-gradient-to-t from-slate-900 to-slate-800 mt-auto">
            <a href="{{ route('logout') }}"
                class="w-full flex items-center justify-center space-x-2 px-4 py-3 rounded-lg bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white transition font-medium border border-red-500/30 hover:border-red-500">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </a>
        </div>
    </aside>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nav = document.querySelector('nav');
            const activeLink = document.querySelector(
                'nav a.bg-blue-700, nav a.bg-purple-700, nav a.bg-indigo-700, nav a.bg-cyan-700, nav a.bg-teal-700, nav a.bg-amber-700, nav a.bg-red-700, nav a.bg-green-700, nav a.bg-emerald-700, nav a.bg-orange-700, nav a.bg-pink-700, nav a.bg-rose-700, nav a.bg-violet-700'
            );

            if (activeLink) {
                const scrollPosition = activeLink.offsetTop - 200;
                nav.scrollTop = scrollPosition;
            }
        });
    </script>
</div>
