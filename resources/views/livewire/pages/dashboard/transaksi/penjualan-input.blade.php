<div>
    <div class="p-8">
        <div class="mb-8">
            <a href="{{ route('penjualan') }}" class="text-blue-600 hover:text-blue-800 font-semibold mb-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <h2 class="text-3xl font-bold text-gray-900">Tambah Penjualan Baru</h2>
            <p class="text-gray-600 mt-2">Buat transaksi penjualan barang kepada pelanggan</p>
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
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Penjualan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
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

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                        <div>
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
                            <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase">Jumlah Jual</label>
                            <input type="number" wire:model="jumlahItem" min="1" step="1"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-500 transition">
                        </div>

                        <div class="flex items-end">
                            <button type="button" wire:click="addItem"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition"
                                @if ($stokPreview <= 0) disabled style="opacity: 0.5; cursor: not-allowed;" @endif>
                                <i class="fas fa-plus mr-1"></i>Tambah
                            </button>
                        </div>
                    </div>

                    @if ($selectedBarang)
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-semibold text-green-700 uppercase">Harga Jual</p>
                                    <p class="text-lg font-bold text-green-600 mt-1">Rp
                                        {{ number_format($hargaJualPreview, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p
                                        class="text-xs font-semibold @if ($stokPreview > 0) text-blue-700 @else text-red-700 @endif uppercase">
                                        Stok Tersedia</p>
                                    <p
                                        class="text-lg font-bold @if ($stokPreview > 0) text-blue-600 @else text-red-600 @endif mt-1">
                                        {{ $stokPreview }}</p>
                                </div>
                            </div>
                            @if ($stokPreview <= 0)
                                <p class="text-red-600 text-sm mt-3 font-medium">
                                    <i class="fas fa-exclamation-circle mr-1"></i>Stok tidak tersedia
                                </p>
                            @endif
                        </div>
                    @endif

                    @error('selectedBarang')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                    @error('jumlahItem')
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
                                        <div class="grid grid-cols-2 gap-3 mt-2 text-xs">
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
                                <span class="text-lg font-bold text-gray-900">Total Penjualan:</span>
                                <span class="text-3xl font-bold text-blue-600">
                                    Rp {{ number_format($this->totalPenjualan, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="border-b pb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Pembayaran</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div
                                class="bg-gradient-to-r from-blue-50 to-blue-100 p-6 rounded-lg border border-blue-200">
                                <p class="text-sm font-medium text-gray-700 mb-2">Total Penjualan</p>
                                <p class="text-3xl font-bold text-blue-600">
                                    Rp {{ number_format($this->totalPenjualan, 0, ',', '.') }}
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
                                        @if ($this->sisaPiutang > 0)
                                            <div class="bg-orange-50 p-3 rounded-lg border border-orange-200">
                                                <p class="text-orange-700 text-sm font-medium">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Sisa Piutang: <span class="font-bold">Rp
                                                        {{ number_format($this->sisaPiutang, 0, ',', '.') }}</span>
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

                        @if ($terbayar > 0 && $this->sisaPiutang > 0)
                            <div class="mt-6">
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
                        @endif
                    </div>
                @else
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 text-center">
                        <p class="text-yellow-800 font-medium">
                            <i class="fas fa-info-circle mr-2"></i>Belum ada barang ditambahkan
                        </p>
                    </div>
                @endif

                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Penjualan
                    </button>
                    <a href="{{ route('penjualan') }}"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-lg transition text-center flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
