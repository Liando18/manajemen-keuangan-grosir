<div>
    <div class="p-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Data Supplier</h2>
            <p class="text-gray-600 mt-2">Kelola data mitra supplier</p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                <p class="text-green-600 text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
                <p class="text-red-600 text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex-1 max-w-md">
                    <input type="text" wire:model.live="search" placeholder="Cari nama, kontak, atau alamat..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                </div>
                <button wire:click="openModal"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Supplier
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Nama Supplier</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Kontak</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Alamat</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Dibuat</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                                            <i class="fas fa-building text-amber-600"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $supplier->nama }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="text-sm text-gray-600">{{ $supplier->kontak }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="text-sm text-gray-600">{{ Str::limit($supplier->alamat, 50) }}</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span
                                        class="text-sm text-gray-600">{{ $supplier->created_at->format('d M Y') }}</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button wire:click="edit({{ $supplier->id }})"
                                            class="bg-yellow-100 hover:bg-yellow-200 text-yellow-600 p-2 rounded-lg transition">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $supplier->id }})"
                                            wire:confirm="Yakin hapus supplier ini?"
                                            class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-3 opacity-50"></i>
                                    <p>Tidak ada data supplier</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $suppliers->links() }}
            </div>
        </div>

        @if ($showModal)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40">
                <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900">
                            {{ $isEdit ? 'Edit Supplier' : 'Tambah Supplier Baru' }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700 text-2xl">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form wire:submit="save" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Supplier</label>
                            <input type="text" wire:model="nama"
                                class="w-full px-4 py-2 border @error('nama') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                placeholder="Nama supplier">
                            @error('nama')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kontak</label>
                            <input type="text" wire:model="kontak"
                                class="w-full px-4 py-2 border @error('kontak') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                placeholder="No. telepon atau email">
                            @error('kontak')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                            <textarea wire:model="alamat" rows="4"
                                class="w-full px-4 py-2 border @error('alamat') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                placeholder="Alamat lengkap supplier"></textarea>
                            @error('alamat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button type="submit"
                                class="flex-1 {{ $isEdit ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white font-semibold py-2 rounded-lg transition">
                                {{ $isEdit ? 'Perbarui' : 'Simpan' }}
                            </button>
                            <button type="button" wire:click="closeModal"
                                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 rounded-lg transition">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
