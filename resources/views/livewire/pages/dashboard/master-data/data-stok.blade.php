<div>
    <div class="p-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Data Stok</h2>
            <p class="text-gray-600 mt-2">Pantau ketersediaan barang</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Stok</p>
                        <p class="text-3xl font-bold mt-2">{{ $totalStok }}</p>
                    </div>
                    <i class="fas fa-boxes text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Stok Tersedia</p>
                        <p class="text-3xl font-bold mt-2">{{ $stokTersedia }}</p>
                    </div>
                    <i class="fas fa-check-circle text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium">Stok Rendah</p>
                        <p class="text-3xl font-bold mt-2">{{ $stokRendah }}</p>
                    </div>
                    <i class="fas fa-exclamation-triangle text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Total Barang dengan Stok Habis</p>
                        <p class="text-3xl font-bold mt-2">{{ $stokHabis }}</p>
                    </div>
                    <i class="fas fa-times-circle text-4xl opacity-20"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4 mb-6 md:items-center">
                <div class="flex-1 max-w-md">
                    <input type="text" wire:model.live="search" placeholder="Cari nama barang atau kategori..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>
                <select wire:model.live="filterStatus"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                    <option value="">Semua Status</option>
                    <option value="tersedia">Tersedia</option>
                    <option value="rendah">Rendah</option>
                    <option value="habis">Habis</option>
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Barang</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Kategori</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Stok</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stoks as $stok)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center">
                                            <i class="fas fa-warehouse text-teal-600"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $stok['nama'] }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="text-sm text-gray-600">{{ $stok['kategori'] }}</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="text-lg font-bold text-gray-900">{{ $stok['jumlah'] }}</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    @if ($stok['jumlah'] == 0)
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i> Habis
                                        </span>
                                    @elseif ($stok['jumlah'] <= 10)
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Rendah
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Tersedia
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-3 opacity-50"></i>
                                    <p>Tidak ada data barang</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $paginator->links() }}
            </div>
        </div>
    </div>
</div>
