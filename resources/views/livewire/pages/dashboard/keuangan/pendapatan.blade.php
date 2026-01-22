<div>
    <div class="p-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Manajemen Pendapatan</h2>
            <p class="text-gray-600 mt-2">Kelola semua pendapatan perusahaan Anda</p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-600 font-semibold">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-600 font-semibold">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Total Pendapatan</p>
                        <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-money-bill-wave text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Transaksi</p>
                        <p class="text-3xl font-bold mt-2">{{ $pendapatans->total() }}</p>
                    </div>
                    <i class="fas fa-list text-4xl opacity-20"></i>
                </div>
            </div>

            {{-- <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Rata-rata Pendapatan</p>
                        <p class="text-3xl font-bold mt-2">Rp
                            {{ $pendapatans->total() > 0 ? number_format($totalPendapatan / $pendapatans->total(), 0, ',', '.') : '0' }}
                        </p>
                    </div>
                    <i class="fas fa-chart-line text-4xl opacity-20"></i>
                </div>
            </div> --}}
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="flex-1">
                    <input type="text" wire:model.live="search" placeholder="Cari sumber atau keterangan..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>
                <button wire:click="openModal"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Pendapatan
                </button>
            </div>

            @if ($pendapatans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b-2 border-gray-200">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Sumber
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Metode
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Jumlah
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Keterangan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($pendapatans as $index => $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ ($pendapatans->currentPage() - 1) * $pendapatans->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $item->sumber }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($item->pembayaran === 'cash')
                                            <span
                                                class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                                                💵 Cash
                                            </span>
                                        @else
                                            <span
                                                class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">
                                                🏦 Transfer
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-green-600">
                                        Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ Str::limit($item->keterangan, 30) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $item->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <button wire:click="edit({{ $item->id }})"
                                                class="bg-yellow-100 hover:bg-yellow-200 text-yellow-600 px-3 py-1 rounded-lg transition text-sm font-medium">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click="delete({{ $item->id }})"
                                                wire:confirm="Yakin hapus data ini?"
                                                class="bg-red-100 hover:bg-red-200 text-red-600 px-3 py-1 rounded-lg transition text-sm font-medium">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $pendapatans->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada data pendapatan</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div wire:click="closeModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                    aria-hidden="true"></div>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                @if ($editingId)
                                    Edit Pendapatan
                                @else
                                    Tambah Pendapatan Baru
                                @endif
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 text-2xl">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <form wire:submit.prevent="save" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Sumber <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="sumber" placeholder="Contoh: Penjualan Retail"
                                    class="w-full px-4 py-2 border @error('sumber') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                                @error('sumber')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Metode Pembayaran <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="pembayaran"
                                    class="w-full px-4 py-2 border @error('pembayaran') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                                    <option value="cash">💵 Cash</option>
                                    <option value="transfer">🏦 Transfer Bank</option>
                                </select>
                                @error('pembayaran')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Bukti <span class="text-gray-500 text-xs">(Opsional)</span>
                                </label>
                                <input type="file" wire:model="buktiFile" accept="image/*,.pdf"
                                    class="w-full px-4 py-2 border @error('buktiFile') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                                <p class="text-xs text-gray-600 mt-1">Format: JPG, JPEG, PNG, atau PDF (Max 5MB)</p>
                                @if ($buktiPath && !$buktiFile)
                                    <div class="mt-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                                        <p class="text-xs text-green-600 mb-2">
                                            <i class="fas fa-check-circle mr-1"></i>File sudah ada
                                        </p>
                                        <a href="{{ asset('storage/' . $buktiPath) }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-800 text-xs font-semibold underline inline-flex items-center gap-1">
                                            <i class="fas fa-external-link-alt"></i> Lihat Bukti
                                        </a>
                                    </div>
                                @endif
                                @error('buktiFile')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jumlah <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model="jumlah" min="0" step="0.01"
                                    placeholder="0"
                                    class="w-full px-4 py-2 border @error('jumlah') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                                @error('jumlah')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Keterangan <span class="text-red-500">*</span>
                                </label>
                                <textarea wire:model="keterangan" rows="3" placeholder="Masukkan keterangan pendapatan"
                                    class="w-full px-4 py-2 border @error('keterangan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition resize-none"></textarea>
                                @error('keterangan')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex gap-3 pt-4">
                                <button type="submit"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition flex items-center justify-center gap-2">
                                    <i class="fas fa-save"></i>
                                    @if ($editingId)
                                        Update
                                    @else
                                        Simpan
                                    @endif
                                </button>
                                <button type="button" wire:click="closeModal"
                                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 rounded-lg transition flex items-center justify-center gap-2">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
