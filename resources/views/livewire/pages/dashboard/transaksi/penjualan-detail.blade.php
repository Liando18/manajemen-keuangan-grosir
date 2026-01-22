<div>
    <div class="p-8">
        <div class="mb-8">
            <a href="{{ route('penjualan') }}"
                class="text-blue-600 hover:text-blue-800 font-semibold mb-4 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Detail Penjualan</h2>
                    <p class="text-gray-600 mt-2">
                        <i class="fas fa-receipt mr-1"></i> ID: <strong>#{{ $penjualan->id }}</strong> |
                        <i class="fas fa-clock mr-1"></i> {{ $penjualan->created_at->format('d M Y H:i') }}
                    </p>
                </div>
                @if (!$isEdit)
                    <button wire:click="toggleEdit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center gap-2">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                @endif
            </div>
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

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-600 font-semibold mb-2">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600 text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-lg p-6 border border-blue-200">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-blue-700">Nama Pelanggan</p>
                    <i class="fas fa-user text-blue-400 text-lg"></i>
                </div>
                <p class="text-lg font-bold text-blue-900">{{ $penjualan->piutang->nama ?? '-' }}</p>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-lg p-6 border border-green-200">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-green-700">Metode Pembayaran</p>
                    <i
                        class="fas @if ($penjualan->pembayaran === 'cash') fa-money-bill-wave @else fa-bank @endif text-green-400 text-lg"></i>
                </div>
                <span
                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-bold
                    @if ($penjualan->pembayaran === 'cash') bg-green-600 text-white
                    @else
                        bg-blue-600 text-white @endif">
                    {{ ucfirst($penjualan->pembayaran) }}
                </span>
            </div>

            <div
                class="bg-gradient-to-br @if ($penjualan->piutang) from-red-50 to-red-100 border border-red-200 @else from-green-50 to-green-100 border border-green-200 @endif rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-2">
                    <p
                        class="text-sm font-medium @if ($penjualan->piutang) text-red-700 @else text-green-700 @endif">
                        Status</p>
                    <i
                        class="fas @if ($penjualan->piutang) fa-exclamation-circle text-red-400 @else fa-check-circle text-green-400 @endif text-lg"></i>
                </div>
                <span
                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-bold
                    @if ($penjualan->piutang) bg-red-600 text-white
                    @else
                        bg-green-600 text-white @endif">
                    @if ($penjualan->piutang)
                        Piutang
                    @else
                        Lunas
                    @endif
                </span>
            </div>
        </div>

        @if (!$isEdit)
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-list mr-2"></i> Detail Item ({{ count($penjualan->penjualanItem) }} item)
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200 bg-gray-50">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Barang</th>
                                <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Jumlah</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Harga Jual</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualan->penjualanItem as $item)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="py-4 px-4">
                                        <p class="text-sm font-medium text-gray-900">{{ $item->barang->nama }}</p>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span
                                            class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            {{ $item->jumlah }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <p class="text-sm text-gray-900">Rp
                                            {{ number_format($item->barang->harga, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <p class="text-sm font-bold text-gray-900">Rp
                                            {{ number_format($item->jumlah * $item->barang->harga, 0, ',', '.') }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-money-bill mr-2"></i> Total Penjualan
                </h3>
                <div class="bg-blue-50 p-6 rounded-lg border-2 border-blue-300">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900">Total:</span>
                        <span class="text-3xl font-bold text-blue-600">Rp
                            {{ number_format($penjualan->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if ($penjualan->piutang)
                    <div class="bg-orange-50 p-6 rounded-lg border-2 border-orange-300 mt-4">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-700">Sudah Terbayar:</span>
                                <span class="text-sm font-bold text-gray-900">Rp
                                    {{ number_format($penjualan->piutang->terbayar, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-700">Sisa Piutang:</span>
                                <span class="text-sm font-bold text-orange-600">Rp
                                    {{ number_format($penjualan->total - $penjualan->piutang->terbayar, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <form wire:submit.prevent="save" class="bg-white rounded-xl shadow-lg p-8 space-y-8">
                <div class="border-b pb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Penjualan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Pelanggan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="nama_pelanggan"
                                class="w-full px-4 py-2 border @error('nama_pelanggan') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                placeholder="Nama pelanggan">
                            @error('nama_pelanggan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Metode Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <select wire:model.live="pembayaran"
                                class="w-full px-4 py-2 border @error('pembayaran') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                                <option value="cash">💵 Cash</option>
                                <option value="transfer">🏦 Transfer</option>
                            </select>
                            @error('pembayaran')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if ($pembayaran === 'transfer')
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Bukti Transfer
                            </label>
                            <input type="file" wire:model="buktiFile" accept="image/*,.pdf"
                                class="w-full px-4 py-2 border @error('buktiFile') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                            <p class="text-xs text-gray-600 mt-1">Format: JPG, JPEG, PNG, atau PDF (Max 5MB)</p>
                            @error('buktiFile')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>

                <div class="border-b pb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Tambah Barang</h3>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-3 mb-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase">Pilih
                                Barang</label>
                            <select wire:model.live="selectedBarang"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-500 transition">
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase">Jumlah Jual</label>
                            <input type="number" wire:model="jumlahItem" min="1" step="1"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase">Harga Jual</label>
                            <input type="number" wire:model.live="hargaItem" min="0" step="0.01"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-500 transition">
                        </div>
                        <div class="flex items-end">
                            <button type="button" wire:click="addItem"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                                <i class="fas fa-plus mr-1"></i>Tambah
                            </button>
                        </div>
                    </div>

                    @if ($selectedBarang)
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-semibold text-green-700 uppercase">Harga Standar</p>
                                    <p class="text-lg font-bold text-green-600 mt-1">Rp
                                        {{ number_format($hargaJualPreview, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-600 uppercase">Harga Input</p>
                                    <p class="text-lg font-bold text-gray-900 mt-1"
                                        wire:key="harga-jual-{{ $hargaItem }}">Rp
                                        {{ $hargaItem ? number_format(floatval($hargaItem), 0, ',', '.') : '0' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @error('selectedBarang')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                    @error('jumlahItem')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                    @error('hargaItem')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                @if (!empty($barangItems))
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Daftar Barang ({{ count($barangItems) }}
                            item)</h3>
                        <div class="space-y-2 mb-6 max-h-80 overflow-y-auto">
                            @foreach ($barangItems as $index => $item)
                                <div
                                    class="flex justify-between items-center bg-gray-50 p-4 rounded-lg border border-gray-200 hover:border-blue-300 transition">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $item['barang_nama'] }}</p>
                                        <div class="grid grid-cols-3 gap-3 mt-2 text-xs">
                                            <div>
                                                <p class="text-gray-500">Jumlah Jual</p>
                                                <p class="font-semibold text-gray-900">{{ $item['jumlah'] }}
                                                    {{ $item['satuan'] }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Harga Jual</p>
                                                <p class="font-semibold text-gray-900">Rp
                                                    {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Harga Standar</p>
                                                <p class="font-semibold text-blue-600">Rp
                                                    {{ number_format($item['harga_jual'], 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right mr-4">
                                        <p class="text-xs text-gray-500 mb-1">Subtotal</p>
                                        <p class="text-sm font-bold text-gray-900">
                                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <button type="button" wire:click="removeItem({{ $index }})"
                                        class="bg-red-100 hover:bg-red-200 text-red-600 p-2 rounded-lg transition">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <div
                            class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg border-2 border-green-300">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">Total Penjualan:</span>
                                <span class="text-3xl font-bold text-green-600">
                                    Rp {{ number_format($this->totalPenjualan, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex gap-3 pt-4 border-t">
                    <button type="submit"
                        class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <button type="button" wire:click="toggleEdit"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
            </form>
        @endif
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
    </style>
</div>
