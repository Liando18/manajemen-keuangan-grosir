<div>
    <div class="p-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Transaksi Pembelian</h2>
            <p class="text-gray-600 mt-2">Kelola pembelian barang dari supplier</p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3 animate-fade-in">
                <i class="fas fa-check-circle text-green-600 mt-0.5 flex-shrink-0"></i>
                <p class="text-green-600 text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3 animate-fade-in">
                <i class="fas fa-exclamation-circle text-red-600 mt-0.5 flex-shrink-0"></i>
                <p class="text-red-600 text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow p-6 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-700 mb-1">Total Transaksi</p>
                        <p class="text-3xl font-bold text-blue-900">{{ $summary['total_pembelian'] }}</p>
                    </div>
                    <i class="fas fa-shopping-cart text-4xl text-blue-300"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow p-6 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-700 mb-1">Total Nilai</p>
                        <p class="text-2xl font-bold text-green-900">Rp
                            {{ number_format($summary['total_nilai'], 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-money-bill-wave text-4xl text-green-300"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl shadow p-6 border border-purple-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-700 mb-1">Bulan Ini</p>
                        <p class="text-3xl font-bold text-purple-900">{{ $summary['pembelian_bulan_ini'] }}</p>
                    </div>
                    <i class="fas fa-calendar text-4xl text-purple-300"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl shadow p-6 border border-orange-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-orange-700 mb-1">Hutang Tertanggur</p>
                        <p class="text-3xl font-bold text-orange-900">{{ $summary['hutang_tertanggur'] }}</p>
                    </div>
                    <i class="fas fa-exclamation-triangle text-4xl text-orange-300"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="mb-6 space-y-4">
                <div class="flex flex-col md:flex-row gap-4 items-start md:items-center">
                    <div class="flex-1 max-w-md">
                        <input type="text" wire:model.live.debounce-300ms="search"
                            placeholder="🔍 Cari supplier atau bukti..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    </div>

                    <select wire:model.live="filterPembayaran"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm">
                        <option value="">Semua Metode</option>
                        <option value="cash">💵 Cash</option>
                        <option value="transfer">🏦 Transfer</option>
                    </select>

                    <select wire:model.live="sortBy"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm">
                        <option value="latest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="total_asc">Total Rendah</option>
                        <option value="total_desc">Total Tinggi</option>
                    </select>

                    <a href="{{ route('pembelian-input') }}"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2 whitespace-nowrap">
                        <i class="fas fa-plus"></i> Tambah Pembelian
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200 bg-gray-50">
                            <th class="text-left py-4 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Supplier</th>
                            <th class="text-left py-4 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Metode</th>
                            <th class="text-right py-4 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Total</th>
                            <th class="text-center py-4 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="text-center py-4 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Status</th>
                            <th class="text-center py-4 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembelians as $pembelian)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-building text-blue-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">
                                                {{ $pembelian->supplier->nama }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-4">
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold
                                        @if ($pembelian->pembayaran === 'cash') bg-green-100 text-green-800
                                        @else
                                            bg-blue-100 text-blue-800 @endif">
                                        <i
                                            class="fas @if ($pembelian->pembayaran === 'cash') fa-money-bill-wave @else fa-bank @endif"></i>
                                        {{ ucfirst($pembelian->pembayaran) }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 text-right">
                                    <span class="text-sm font-bold text-gray-900">Rp
                                        {{ number_format($pembelian->total, 0, ',', '.') }}</span>
                                </td>

                                <td class="py-4 px-4 text-center">
                                    <span
                                        class="text-sm text-gray-600">{{ $pembelian->created_at->format('d M Y') }}</span>
                                </td>

                                <td class="py-4 px-4 text-center">
                                    @if ($pembelian->hutang)
                                        @if ($pembelian->hutang->status == 'belum')
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                                <i class="fas fa-exclamation-circle"></i>
                                                {{ ucfirst($pembelian->hutang->status) }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle"></i>
                                                {{ ucfirst($pembelian->hutang->status) }}
                                            </span>
                                        @endif
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle"></i> Lunas
                                        </span>
                                    @endif

                                </td>

                                <td class="py-4 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('pembelian-detail', $pembelian->id) }}"
                                            class="bg-blue-100 hover:bg-blue-200 text-blue-600 p-2 rounded-lg transition tooltip"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button wire:click="delete({{ $pembelian->id }})"
                                            wire:confirm="Yakin hapus pembelian ini? Stok akan dikembalikan."
                                            class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition tooltip"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                                        <p class="text-gray-500 font-medium">Tidak ada data pembelian</p>
                                        <p class="text-gray-400 text-sm mt-1">Mulai dengan menambahkan pembelian baru
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 border-t pt-6">
                {{ $pembelians->links() }}
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        .tooltip:hover::after {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</div>
