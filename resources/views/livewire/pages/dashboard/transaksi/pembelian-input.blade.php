<div>
    <div class="p-8">
        <div class="mb-8">
            <a href="{{ route('pembelian') }}" class="text-blue-600 hover:text-blue-800 font-semibold mb-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <h2 class="text-3xl font-bold text-gray-900">Tambah Pembelian Baru</h2>
            <p class="text-gray-600 mt-2">Buat transaksi pembelian barang dari supplier</p>
        </div>

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

        <div class="bg-white rounded-xl shadow-lg p-8">
            <form wire:submit.prevent="save" class="space-y-8">
                <div class="border-b pb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Pembelian</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                <option value="transfer">🏦 Transfer Bank</option>
                            </select>
                            @error('pembayaran')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if ($pembayaran === 'transfer')
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Bukti Transfer <span class="text-red-500">*</span>
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
                            <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase">Pilih Barang</label>
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
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Daftar Barang ({{ count($barangItems) }} item)
                        </h3>

                        <div class="space-y-2 mb-6 max-h-96 overflow-y-auto">
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

                        <div class="bg-blue-50 p-4 rounded-lg border-2 border-blue-300">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">Total Pembelian:</span>
                                <span class="text-3xl font-bold text-blue-600">
                                    Rp {{ number_format($this->totalPembelian, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 text-center">
                        <p class="text-yellow-800 font-medium">
                            <i class="fas fa-info-circle mr-2"></i>Belum ada barang ditambahkan
                        </p>
                    </div>
                @endif

                <div class="border-b pb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Pembayaran</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-6 rounded-lg border border-blue-200">
                            <p class="text-sm font-medium text-gray-700 mb-2">Total Pembayaran</p>
                            <p class="text-3xl font-bold text-blue-600">
                                Rp {{ number_format($this->totalPembelian, 0, ',', '.') }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah Terbayar <span class="text-red-500">*</span>
                            </label>
                            <input type="number" wire:model.live="terbayar" step="0.01" min="0"
                                class="w-full px-4 py-3 border @error('terbayar') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-lg font-semibold"
                                placeholder="0">
                            @error('terbayar')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            @if ($terbayar > 0)
                                <div class="mt-3">
                                    @if ($this->sisaHutang > 0)
                                        <div class="bg-orange-50 p-3 rounded-lg border border-orange-200">
                                            <p class="text-orange-700 text-sm font-medium">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Sisa Hutang: <span class="font-bold">Rp
                                                    {{ number_format($this->sisaHutang, 0, ',', '.') }}</span>
                                            </p>
                                        </div>
                                    @elseif ($this->kelebihan > 0)
                                        <div class="bg-green-50 p-3 rounded-lg border border-green-200">
                                            <p class="text-green-700 text-sm font-medium">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Kembalian: <span class="font-bold">Rp
                                                    {{ number_format($this->kelebihan, 0, ',', '.') }}</span>
                                            </p>
                                        </div>
                                    @else
                                        <div class="bg-green-50 p-3 rounded-lg border border-green-200">
                                            <p class="text-green-700 text-sm font-medium">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Pembayaran Lunas
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Pembelian
                    </button>
                    <a href="{{ route('pembelian') }}"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-lg transition text-center flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
