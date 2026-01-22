<div>
    <div class="p-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Data Barang</h2>
            <p class="text-gray-600 mt-2">Kelola data produk, harga, dan satuan</p>
        </div>

        <!-- Alert Messages -->
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

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <!-- Toolbar -->
            <div class="flex flex-col md:flex-row gap-4 items-start md:items-center mb-6">
                <div class="flex-1 max-w-md">
                    <input type="text" wire:model.live.debounce-300ms="search"
                        placeholder="🔍 Cari nama atau kategori..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>
                <button wire:click="openModal"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2 whitespace-nowrap">
                    <i class="fas fa-plus"></i> Tambah Barang
                </button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200 bg-gray-50">
                            <th class="text-left py-3 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Nama Barang</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Kategori</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Satuan</th>
                            <th class="text-right py-3 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Harga Beli</th>
                            <th class="text-right py-3 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Harga Jual</th>
                            <th class="text-right py-3 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Laba</th>
                            <th class="text-center py-3 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Dibuat</th>
                            <th class="text-center py-3 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $barang)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-cyan-100 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-box text-cyan-600"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $barang['nama'] }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span
                                        class="inline-block px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $barang['kategori'] }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <span
                                        class="inline-block px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ $barang['satuan'] }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <span class="text-sm font-semibold text-gray-900">
                                        @if ($barang['harga_beli'] > 0)
                                            Rp {{ number_format($barang['harga_beli'], 0, ',', '.') }}
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <span class="text-sm font-semibold text-blue-600">
                                        Rp {{ number_format($barang['harga_jual'], 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <span
                                        class="text-sm font-semibold 
                                        @if ($barang['harga_beli'] > 0) {{ $barang['laba'] > 0 ? 'text-green-600' : ($barang['laba'] < 0 ? 'text-red-600' : 'text-gray-400') }}
                                        @else
                                            text-gray-400 @endif">
                                        @if ($barang['harga_beli'] > 0)
                                            {{ $barang['laba'] > 0 ? '+' : '' }}Rp
                                            {{ number_format($barang['laba'], 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span
                                        class="text-sm text-gray-600">{{ $barang['created_at']->format('d M Y') }}</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button wire:click="edit({{ $barang['id'] }})"
                                            class="bg-yellow-100 hover:bg-yellow-200 text-yellow-600 p-2 rounded-lg transition">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $barang['id'] }})"
                                            wire:confirm="Yakin hapus barang ini?"
                                            class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                                        <p class="text-gray-500 font-medium">Tidak ada data barang</p>
                                        <p class="text-gray-400 text-sm mt-1">Mulai dengan menambahkan barang baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 border-t pt-6">
                {{ $paginator->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md max-h-screen overflow-y-auto">
                <!-- Modal Header -->
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">
                        <i class="fas @if ($isEdit) fa-edit @else fa-plus-circle @endif mr-2"></i>
                        {{ $isEdit ? 'Edit Barang' : 'Tambah Barang Baru' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700 text-2xl transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-600 font-semibold text-sm mb-2">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-red-600 text-xs">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form wire:submit.prevent="save" class="space-y-4">
                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="kategori_id"
                            class="w-full px-4 py-2 border @error('kategori_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Satuan <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="satuan_id"
                            class="w-full px-4 py-2 border @error('satuan_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                            <option value="">-- Pilih Satuan --</option>
                            @foreach ($satuans as $satuan)
                                <option value="{{ $satuan->id }}">
                                    {{ $satuan->singkatan ? $satuan->singkatan . ' (' . $satuan->nama . ')' : $satuan->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('satuan_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Barang -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="nama"
                            class="w-full px-4 py-2 border @error('nama') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="Contoh: Laptop Dell XPS 13">
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga Jual -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Harga Jual <span class="text-red-500">*</span>
                        </label>
                        <input type="number" wire:model="harga" step="0.01" min="0"
                            class="w-full px-4 py-2 border @error('harga') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="Harga jual ke customer">
                        @error('harga')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4 border-t">
                        <button type="submit"
                            class="flex-1 @if ($isEdit) bg-yellow-600 hover:bg-yellow-700 @else bg-green-600 hover:bg-green-700 @endif text-white font-bold py-2 rounded-lg transition flex items-center justify-center gap-2">
                            <i class="fas @if ($isEdit) fa-save @else fa-plus @endif"></i>
                            {{ $isEdit ? 'Perbarui' : 'Simpan' }}
                        </button>
                        <button type="button" wire:click="closeModal"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 rounded-lg transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

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
    </style>
</div>
