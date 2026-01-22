<div>
    <div class="p-8">
        <div class="mb-8">
            <h2 class="text-4xl font-bold text-gray-900 mb-2">Selamat Datang Kembali, {{ Auth::user()->nama }}! 👋</h2>
            <p class="text-gray-600">
                @if ($userRole === 'admin')
                    Ringkasan keuangan Grosir Netral untuk bulan {{ now()->format('F Y') }}
                @elseif($userRole === 'pemilik')
                    Laporan keuangan dan performa bisnis bulan {{ now()->format('F Y') }}
                @elseif($userRole === 'bendahara')
                    Ringkasan keuangan dan transaksi bulan {{ now()->format('F Y') }}
                @elseif($userRole === 'kasir')
                    Dashboard penjualan dan transaksi kasir bulan {{ now()->format('F Y') }}
                @elseif($userRole === 'gudang')
                    Dashboard pembelian dan manajemen stok bulan {{ now()->format('F Y') }}
                @endif
            </p>
        </div>

        @if (in_array($userRole, ['admin', 'pemilik', 'bendahara']))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 border-l-4 border-blue-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-2">Total Pendapatan</p>
                            <p class="text-3xl font-bold text-gray-900">Rp {{ $formatRupiah($totalPendapatan) }}</p>
                            <p class="text-xs text-gray-500 font-semibold mt-3"><i class="fas fa-calendar mr-1"></i>
                                Bulan ini</p>
                        </div>
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-lg shadow-md">
                            <i class="fas fa-arrow-up text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 border-l-4 border-red-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-2">Total Pengeluaran</p>
                            <p class="text-3xl font-bold text-gray-900">Rp {{ $formatRupiah($totalPengeluaran) }}</p>
                            <p class="text-xs text-gray-500 font-semibold mt-3"><i class="fas fa-calendar mr-1"></i>
                                Bulan ini</p>
                        </div>
                        <div class="bg-gradient-to-br from-red-500 to-red-600 p-4 rounded-lg shadow-md">
                            <i class="fas fa-arrow-down text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 border-l-4 border-orange-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-2">Total Hutang</p>
                            <p class="text-3xl font-bold text-gray-900">Rp {{ $formatRupiah($totalHutang) }}</p>
                            <p class="text-xs text-orange-600 font-semibold mt-3"><i
                                    class="fas fa-exclamation-circle mr-1"></i> Belum Lunas</p>
                        </div>
                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-4 rounded-lg shadow-md">
                            <i class="fas fa-file-invoice text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 border-l-4 border-purple-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-2">Total Piutang</p>
                            <p class="text-3xl font-bold text-gray-900">Rp {{ $formatRupiah($totalPiutang) }}</p>
                            <p class="text-xs text-purple-600 font-semibold mt-3"><i class="fas fa-clock mr-1"></i>
                                Belum Lunas</p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-4 rounded-lg shadow-md">
                            <i class="fas fa-handshake text-2xl text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Ringkasan Keuangan</h3>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-semibold text-gray-700">Pendapatan</span>
                                <span
                                    class="text-sm font-bold text-blue-600">{{ $totalPendapatan > 0 ? round(($totalPendapatan / ($totalPendapatan + $totalPengeluaran)) * 100) : 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 shadow-inner">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full"
                                    style="width: {{ $totalPendapatan > 0 ? round(($totalPendapatan / ($totalPendapatan + $totalPengeluaran)) * 100) : 0 }}%">
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-semibold text-gray-700">Pengeluaran</span>
                                <span
                                    class="text-sm font-bold text-red-600">{{ $totalPengeluaran > 0 ? round(($totalPengeluaran / ($totalPendapatan + $totalPengeluaran)) * 100) : 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 shadow-inner">
                                <div class="bg-gradient-to-r from-red-500 to-red-600 h-3 rounded-full"
                                    style="width: {{ $totalPengeluaran > 0 ? round(($totalPengeluaran / ($totalPendapatan + $totalPengeluaran)) * 100) : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-gray-600 text-sm">Total</p>
                                <p class="text-2xl font-bold text-gray-900">Rp
                                    {{ $formatRupiah($totalPendapatan + $totalPengeluaran) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Saldo Bersih</p>
                                <p
                                    class="text-2xl font-bold {{ $totalPendapatan - $totalPengeluaran >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ $formatRupiah(abs($totalPendapatan - $totalPengeluaran)) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-sm">Efisiensi</p>
                                <p class="text-2xl font-bold text-green-600">
                                    {{ $totalPendapatan > 0 ? round((($totalPendapatan - $totalPengeluaran) / $totalPendapatan) * 100) : 0 }}%
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Status Piutang & Hutang</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Total Hutang</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">Rp {{ $formatRupiah($totalHutang) }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Total Piutang</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">Rp {{ $formatRupiah($totalPiutang) }}</span>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t-2 border-gray-300">
                            <span class="text-sm font-bold text-gray-700">Transaksi Hari Ini</span>
                            <span class="text-lg font-bold text-blue-600">{{ $transaksiHariIni }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($userRole === 'kasir')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 border-l-4 border-green-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-2">Total Penjualan</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalPenjualan }}</p>
                            <p class="text-xs text-gray-500 font-semibold mt-3"><i class="fas fa-calendar mr-1"></i>
                                Bulan ini</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-4 rounded-lg shadow-md">
                            <i class="fas fa-shopping-cart text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 border-l-4 border-blue-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-2">Transaksi Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $transaksiHariIni }}</p>
                            <p class="text-xs text-gray-500 font-semibold mt-3"><i class="fas fa-clock mr-1"></i> Hari
                                ini</p>
                        </div>
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-lg shadow-md">
                            <i class="fas fa-chart-line text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 border-l-4 border-purple-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-2">Akses Cepat</p>
                            <a href="{{ route('penjualan-input') }}"
                                class="inline-block mt-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                <i class="fas fa-plus mr-2"></i>Transaksi Baru
                            </a>
                        </div>
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-4 rounded-lg shadow-md">
                            <i class="fas fa-bolt text-2xl text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($userRole === 'gudang')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 border-l-4 border-indigo-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-2">Total Pembelian</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalPembelian }}</p>
                            <p class="text-xs text-gray-500 font-semibold mt-3"><i class="fas fa-calendar mr-1"></i>
                                Bulan ini</p>
                        </div>
                        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-4 rounded-lg shadow-md">
                            <i class="fas fa-boxes text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 border-l-4 border-red-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-2">Stok Menipis</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stokMenipis }}</p>
                            <p class="text-xs text-red-600 font-semibold mt-3"><i
                                    class="fas fa-exclamation-triangle mr-1"></i> Perlu Perhatian</p>
                        </div>
                        <div class="bg-gradient-to-br from-red-500 to-red-600 p-4 rounded-lg shadow-md">
                            <i class="fas fa-warehouse text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition p-6 border-l-4 border-blue-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold mb-2">Transaksi Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $transaksiHariIni }}</p>
                            <p class="text-xs text-gray-500 font-semibold mt-3"><i class="fas fa-clock mr-1"></i> Hari
                                ini</p>
                        </div>
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-lg shadow-md">
                            <i class="fas fa-chart-line text-2xl text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('pembelian-input') }}"
                        class="p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition text-center">
                        <i class="fas fa-plus-circle text-3xl text-indigo-600 mb-2"></i>
                        <p class="text-sm font-semibold text-gray-700">Pembelian Baru</p>
                    </a>
                    <a href="{{ route('data-stok') }}"
                        class="p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition text-center">
                        <i class="fas fa-box text-3xl text-blue-600 mb-2"></i>
                        <p class="text-sm font-semibold text-gray-700">Kelola Stok</p>
                    </a>
                    <a href="{{ route('pembelian') }}"
                        class="p-4 bg-green-50 rounded-lg hover:bg-green-100 transition text-center">
                        <i class="fas fa-list text-3xl text-green-600 mb-2"></i>
                        <p class="text-sm font-semibold text-gray-700">Riwayat Pembelian</p>
                    </a>
                    <a href="{{ route('data-supplier') }}"
                        class="p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition text-center">
                        <i class="fas fa-truck text-3xl text-purple-600 mb-2"></i>
                        <p class="text-sm font-semibold text-gray-700">Data Supplier</p>
                    </a>
                </div>
            </div> --}}
        @endif

        @if (!empty($recentTransactions))
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">
                        @if ($userRole === 'kasir')
                            Transaksi Penjualan Terbaru
                        @elseif($userRole === 'gudang')
                            Transaksi Pembelian Terbaru
                        @else
                            Transaksi Terbaru
                        @endif
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Deskripsi</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Kategori</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tanggal</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaction)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="{{ $transaction['icon_bg'] }} p-2 rounded-lg">
                                                <i
                                                    class="fas fa-{{ $transaction['icon'] }} {{ $transaction['icon_color'] }}"></i>
                                            </div>
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ $transaction['deskripsi'] }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4"><span
                                            class="text-sm text-gray-600">{{ $transaction['kategori'] }}</span></td>
                                    <td class="py-4 px-4"><span
                                            class="text-sm text-gray-600">{{ $transaction['tanggal'] }}</span></td>
                                    <td class="py-4 px-4 text-right">
                                        <span
                                            class="text-sm font-bold {{ $transaction['icon'] === 'arrow-up' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $transaction['icon'] === 'arrow-up' ? '+' : '-' }}Rp
                                            {{ $transaction['nominal_format'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
