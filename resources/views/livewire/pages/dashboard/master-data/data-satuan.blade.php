<div>
    <div class="p-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Data Satuan</h2>
            <p class="text-gray-600 mt-2">Kelola satuan pengukuran produk</p>
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
                        placeholder="🔍 Cari nama atau singkatan..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>
                <button wire:click="openModal"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2 whitespace-nowrap">
                    <i class="fas fa-plus"></i> Tambah Satuan
                </button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200 bg-gray-50">
                            <th class="text-left py-3 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Nama Satuan</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Singkatan</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Keterangan</th>
                            <th class="text-center py-3 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Digunakan</th>
                            <th class="text-center py-3 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Dibuat</th>
                            <th class="text-center py-3 px-4 text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($satuans as $satuan)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <!-- Nama Satuan -->
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-ruler text-indigo-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $satuan->nama }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Singkatan -->
                                <td class="py-4 px-4">
                                    @if ($satuan->singkatan)
                                        <span
                                            class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            {{ $satuan->singkatan }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>

                                <!-- Keterangan -->
                                <td class="py-4 px-4">
                                    @if ($satuan->keterangan)
                                        <span
                                            class="text-sm text-gray-600">{{ Str::limit($satuan->keterangan, 50) }}</span>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>

                                <!-- Digunakan -->
                                <td class="py-4 px-4 text-center">
                                    @if ($satuan->barang_count > 0)
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            <i class="fas fa-box"></i> {{ $satuan->barang_count }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                            Tidak digunakan
                                        </span>
                                    @endif
                                </td>

                                <!-- Dibuat -->
                                <td class="py-4 px-4 text-center">
                                    <span
                                        class="text-sm text-gray-600">{{ $satuan->created_at->format('d M Y') }}</span>
                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button wire:click="edit({{ $satuan->id }})"
                                            class="bg-yellow-100 hover:bg-yellow-200 text-yellow-600 p-2 rounded-lg transition"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $satuan->id }})"
                                            wire:confirm="Yakin hapus satuan ini?"
                                            class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition"
                                            @if ($satuan->barang_count > 0) disabled style="opacity: 0.5; cursor: not-allowed;" title="Tidak dapat dihapus (sudah digunakan)" @else title="Hapus" @endif>
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
                                        <p class="text-gray-500 font-medium">Tidak ada data satuan</p>
                                        <p class="text-gray-400 text-sm mt-1">Mulai dengan menambahkan satuan baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 border-t pt-6">
                {{ $satuans->links() }}
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
                        {{ $isEdit ? 'Edit Satuan' : 'Tambah Satuan Baru' }}
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
                    <!-- Nama Satuan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Satuan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="nama"
                            class="w-full px-4 py-2 border @error('nama') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="Contoh: Kilogram, Liter, Meter">
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Singkatan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Singkatan <span class="text-gray-400 text-xs">(Opsional)</span>
                        </label>
                        <input type="text" wire:model="singkatan"
                            class="w-full px-4 py-2 border @error('singkatan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            placeholder="Contoh: kg, L, m" maxlength="10">
                        <p class="text-gray-400 text-xs mt-1">Maksimal 10 karakter</p>
                        @error('singkatan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Keterangan <span class="text-gray-400 text-xs">(Opsional)</span>
                        </label>
                        <textarea wire:model="keterangan"
                            class="w-full px-4 py-2 border @error('keterangan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition resize-none"
                            placeholder="Deskripsi atau catatan satuan..." rows="3" maxlength="500"></textarea>
                        <p class="text-gray-400 text-xs mt-1">Maksimal 500 karakter</p>
                        @error('keterangan')
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
