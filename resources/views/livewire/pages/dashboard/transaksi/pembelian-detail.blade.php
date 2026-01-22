<div>
    <div class="p-8">
        <div class="mb-8">
            <a href="{{ route('pembelian') }}"
                class="text-blue-600 hover:text-blue-800 font-semibold mb-4 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Detail Pembelian</h2>
                    <p class="text-gray-600 mt-2">
                        <i class="fas fa-receipt mr-1"></i> ID: <strong>#{{ $pembelian->id }}</strong> |
                        <i class="fas fa-clock mr-1"></i> {{ $pembelian->created_at->format('d M Y H:i') }}
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

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-lg p-6 border border-blue-200">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-blue-700">Supplier</p>
                    <i class="fas fa-building text-blue-400 text-lg"></i>
                </div>
                <p class="text-lg font-bold text-blue-900">{{ $pembelian->supplier->nama }}</p>
                <p class="text-xs text-blue-700 mt-2">{{ $pembelian->supplier->kontak ?? '-' }}</p>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-lg p-6 border border-green-200">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-green-700">Metode Pembayaran</p>
                    <i
                        class="fas @if ($pembelian->pembayaran === 'cash') fa-money-bill-wave @else fa-bank @endif text-green-400 text-lg"></i>
                </div>
                <span
                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-bold
                    @if ($pembelian->pembayaran === 'cash') bg-green-600 text-white
                    @else
                        bg-blue-600 text-white @endif">
                    {{ ucfirst($pembelian->pembayaran) }}
                </span>
            </div>

            <div
                class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl shadow-lg p-6 border border-purple-200">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-purple-700">Total Pembelian</p>
                    <i class="fas fa-money-bill text-purple-400 text-lg"></i>
                </div>
                <p class="text-2xl font-bold text-purple-900">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</p>
            </div>

            <div
                class="bg-gradient-to-br @if ($pembelian->hutang) from-red-50 to-red-100 border border-red-200 @else from-green-50 to-green-100 border border-green-200 @endif rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-2">
                    <p
                        class="text-sm font-medium @if ($pembelian->hutang) text-red-700 @else text-green-700 @endif">
                        Status</p>
                    <i
                        class="fas @if ($pembelian->hutang) fa-exclamation-circle text-red-400 @else fa-check-circle text-green-400 @endif text-lg"></i>
                </div>
                <span
                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-bold
                    @if ($pembelian->hutang) bg-red-600 text-white
                    @else
                        bg-green-600 text-white @endif">
                    @if ($pembelian->hutang)
                        Hutang
                    @else
                        Lunas
                    @endif
                </span>
            </div>
        </div>

        @if (!$isEdit)
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-list mr-2"></i> Detail Item ({{ count($pembelian->pembelianItem) }} item)
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200 bg-gray-50">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Barang</th>
                                <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Jumlah</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Harga Satuan</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembelian->pembelianItem as $item)
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
                                            {{ number_format($item->harga, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <p class="text-sm font-bold text-gray-900">Rp
                                            {{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-file-upload mr-2"></i> Bukti Pembayaran
                </h3>
                @if ($pembelian->pembayaran === 'transfer' && $pembelian->bukti)
                    @php
                        $ext = strtolower(pathinfo($pembelian->bukti, PATHINFO_EXTENSION));
                        $isPdf = $ext === 'pdf';
                    @endphp
                    <div class="max-w-2xl">
                        @if ($isPdf)
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm font-medium text-gray-700">
                                        <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                        {{ basename($pembelian->bukti) }}
                                    </span>
                                </div>
                                <a href="{{ \Storage::url($pembelian->bukti) }}" target="_blank"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                                    <i class="fas fa-download"></i> Download PDF
                                </a>
                            </div>
                        @else
                            <img src="{{ \Storage::url($pembelian->bukti) }}" alt="Bukti Pembayaran"
                                class="w-full max-h-96 object-contain rounded-lg border border-gray-200 shadow-md">
                        @endif
                    </div>
                @elseif ($pembelian->pembayaran === 'cash' && $pembelian->bukti)
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <p class="text-blue-900 font-medium">
                            <i class="fas fa-note-sticky mr-2"></i> {{ $pembelian->bukti }}
                        </p>
                    </div>
                @else
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-center">
                        <p class="text-gray-600">
                            <i class="fas fa-inbox text-2xl text-gray-300 mb-2 block"></i>
                            Tidak ada bukti pembayaran
                        </p>
                    </div>
                @endif
            </div>
        @else
            <form wire:submit.prevent="save" class="bg-white rounded-xl shadow-lg p-8 space-y-8">
                <div class="border-b pb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Pembelian</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Supplier <span class="text-red-500">*</span>
                            </label>
                            <select wire:model.live="supplier_id"
                                class="w-full px-4 py-2 border @error('supplier_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id')
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Bukti Pembayaran
                            </label>
                            @if ($pembayaran === 'cash')
                                <input type="text" wire:model="bukti"
                                    class="w-full px-4 py-2 border @error('bukti') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                    placeholder="No. kwitansi, catatan, dll">
                            @else
                                <input type="file" wire:model="buktiFile" accept="image/*,.pdf"
                                    class="w-full px-4 py-2 border @error('buktiFile') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                                <p class="text-xs text-gray-600 mt-1">Format: JPG, JPEG, PNG, atau PDF (Max 5MB)</p>
                            @endif
                            @error('bukti')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            @error('buktiFile')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
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
                            <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase">Jumlah Beli</label>
                            <input type="number" wire:model="jumlahItem" min="1" step="1"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase">Harga Beli</label>
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
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs font-semibold text-green-700 uppercase">Harga Jual Produk</p>
                                    <p class="text-lg font-bold text-green-600 mt-1">Rp
                                        {{ number_format($hargaJualPreview, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-600 uppercase">Harga Beli (Input)</p>
                                    <p class="text-lg font-bold text-gray-900 mt-1"
                                        wire:key="harga-beli-{{ $hargaItem }}">Rp
                                        {{ $hargaItem ? number_format(floatval($hargaItem), 0, ',', '.') : '0' }}</p>
                                </div>
                                <div>
                                    <p
                                        class="text-xs font-semibold @if (floatval($hargaItem) > 0 && floatval($hargaItem) <= floatval($hargaJualPreview)) text-green-700 @else text-gray-600 @endif uppercase">
                                        Margin Keuntungan</p>
                                    @if (floatval($hargaItem) > 0)
                                        <p class="text-lg font-bold @if (floatval($hargaItem) <= floatval($hargaJualPreview)) text-green-600 @else text-red-600 @endif mt-1"
                                            wire:key="margin-{{ $hargaItem }}">
                                            Rp
                                            {{ number_format(floatval($hargaJualPreview) - floatval($hargaItem), 0, ',', '.') }}
                                        </p>
                                    @else
                                        <p class="text-lg font-bold text-gray-600 mt-1">Rp 0</p>
                                    @endif
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
                                                <p class="text-gray-500">Jumlah Beli</p>
                                                <p class="font-semibold text-gray-900">{{ $item['jumlah'] }}
                                                    {{ $item['satuan'] }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Harga Beli</p>
                                                <p class="font-semibold text-gray-900">Rp
                                                    {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Harga Jual</p>
                                                <p class="font-semibold text-green-600">Rp
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
                                <span class="text-lg font-bold text-gray-900">Total Pembelian:</span>
                                <span class="text-3xl font-bold text-green-600">
                                    Rp {{ number_format($this->totalPembelian, 0, ',', '.') }}
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
