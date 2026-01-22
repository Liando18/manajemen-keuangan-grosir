<div>
    <div class="p-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Manajemen Hutang & Piutang</h2>
            <p class="text-gray-600 mt-2">Kelola hutang kepada supplier dan piutang dari pelanggan</p>
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

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Sisa Hutang</p>
                        <p class="text-2xl font-bold mt-2">Rp {{ number_format($hutangBelum, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-arrow-down text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Total Hutang</p>
                        <p class="text-2xl font-bold mt-2">Rp {{ number_format($totalHutang, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-exclamation-triangle text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-cyan-100 text-sm font-medium">Sisa Piutang</p>
                        <p class="text-2xl font-bold mt-2">Rp {{ number_format($piutangBelum, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-arrow-up text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-pink-100 text-sm font-medium">Total Piutang</p>
                        <p class="text-2xl font-bold mt-2">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-exclamation-triangle text-4xl opacity-20"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="mb-6">
                <div class="flex flex-col md:flex-row gap-4 md:items-center">
                    <h3 class="text-xl font-bold text-gray-900">
                        <i class="fas fa-exchange-alt mr-2"></i>Hutang & Piutang
                    </h3>
                    <div class="flex flex-col md:flex-row gap-2 md:ml-auto">
                        <input type="text" wire:model.live="searchHutang" placeholder="Cari hutang/piutang..."
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm">
                        <select wire:model.live="statusFilterHutang"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm">
                            <option value="">Semua Status</option>
                            <option value="belum">Belum Bayar</option>
                            <option value="lunas">Lunas</option>
                        </select>
                    </div>
                </div>
            </div>

            @if ($hutangs->count() > 0 || $piutangs->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b-2 border-gray-200">
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Jenis</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-700">Total</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-700">Terbayar</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-700">Sisa</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-700">Status</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php $no = 1; @endphp
                            @foreach ($hutangs as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 text-gray-900">{{ $no++ }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-xs font-medium">
                                            <i class="fas fa-arrow-down mr-1"></i>Hutang
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        {{ $item->supplier->nama }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-gray-900">
                                        Rp {{ number_format($item->pembelian->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold text-blue-600">
                                        Rp {{ number_format($item->terbayar, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold text-orange-600">
                                        Rp {{ number_format($item->pembelian->total - $item->terbayar, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium {{ $item->status === 'belum' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-2">
                                            <button wire:click="editHutang({{ $item->id }})"
                                                class="bg-yellow-100 hover:bg-yellow-200 text-yellow-600 px-3 py-1 rounded-lg transition text-sm font-medium">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click="deleteHutang({{ $item->id }})"
                                                wire:confirm="Yakin hapus hutang ini?"
                                                class="bg-red-100 hover:bg-red-200 text-red-600 px-3 py-1 rounded-lg transition text-sm font-medium">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @foreach ($piutangs as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 text-gray-900">{{ $no++ }}</td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="bg-cyan-100 text-cyan-800 px-3 py-1 rounded-full text-xs font-medium">
                                            <i class="fas fa-arrow-up mr-1"></i>Piutang
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        {{ $item->nama }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-gray-900">
                                        Rp {{ number_format($item->penjualan->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold text-blue-600">
                                        Rp {{ number_format($item->terbayar, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold text-cyan-600">
                                        Rp {{ number_format($item->penjualan->total - $item->terbayar, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium {{ $item->status === 'belum' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center gap-2">
                                            <button wire:click="editPiutang({{ $item->id }})"
                                                class="bg-yellow-100 hover:bg-yellow-200 text-yellow-600 px-3 py-1 rounded-lg transition text-sm font-medium">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click="deletePiutang({{ $item->id }})"
                                                wire:confirm="Yakin hapus piutang ini?"
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

                <div class="mt-4 flex gap-4">
                    <div class="flex-1">
                        {{ $hutangs->links(data: ['paginator' => 'hutang_page']) }}
                    </div>
                    <div class="flex-1">
                        {{ $piutangs->links(data: ['paginator' => 'piutang_page']) }}
                    </div>
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-check-circle text-6xl text-green-400 mb-4"></i>
                    <p class="text-lg">Tidak ada hutang dan piutang</p>
                </div>
            @endif
        </div>
    </div>

    @if ($showModalHutang)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div wire:click="closeModalHutang" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                    aria-hidden="true"></div>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                Pembayaran Hutang
                            </h3>
                            <button wire:click="closeModalHutang" class="text-gray-400 hover:text-gray-600 text-2xl">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <form wire:submit.prevent="saveHutang" class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-600 mb-1">Total Hutang</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    Rp {{ number_format($hutangTotal, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-xs text-blue-600 mb-1">Sudah Terbayar</p>
                                <p class="text-xl font-bold text-blue-900">
                                    Rp {{ number_format($hutangTotal, 0, ',', '.') }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jumlah Pembayaran <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model="bayarHutangNominal" min="0" step="0.01"
                                    placeholder="0"
                                    class="w-full px-4 py-2 border @error('bayarHutangNominal') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-lg font-semibold">
                                @error('bayarHutangNominal')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @if ($bayarHutangNominal)
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <p class="text-xs text-green-600 mb-1">Total Setelah Pembayaran</p>
                                    <p class="text-xl font-bold text-green-900">
                                        Rp
                                        {{ number_format($hutangTotal + floatval($bayarHutangNominal), 0, ',', '.') }}
                                    </p>
                                </div>
                            @endif

                            <div class="flex gap-3 pt-4">
                                <button type="submit"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition flex items-center justify-center gap-2">
                                    <i class="fas fa-save"></i> Bayar
                                </button>
                                <button type="button" wire:click="closeModalHutang"
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

    @if ($showModalPiutang)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div wire:click="closeModalPiutang" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                    aria-hidden="true"></div>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">
                                Penerimaan Piutang
                            </h3>
                            <button wire:click="closeModalPiutang" class="text-gray-400 hover:text-gray-600 text-2xl">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <form wire:submit.prevent="savePiutang" class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-600 mb-1">Total Piutang</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    Rp {{ number_format($piutangTotal, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-xs text-blue-600 mb-1">Sudah Diterima</p>
                                <p class="text-xl font-bold text-blue-900">
                                    Rp {{ number_format($piutangTotal, 0, ',', '.') }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jumlah Penerimaan <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model="bayarPiutangNominal" min="0" step="0.01"
                                    placeholder="0"
                                    class="w-full px-4 py-2 border @error('bayarPiutangNominal') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-lg font-semibold">
                                @error('bayarPiutangNominal')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @if ($bayarPiutangNominal)
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <p class="text-xs text-green-600 mb-1">Total Setelah Penerimaan</p>
                                    <p class="text-xl font-bold text-green-900">
                                        Rp
                                        {{ number_format($piutangTotal + floatval($bayarPiutangNominal), 0, ',', '.') }}
                                    </p>
                                </div>
                            @endif

                            <div class="flex gap-3 pt-4">
                                <button type="submit"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition flex items-center justify-center gap-2">
                                    <i class="fas fa-save"></i> Terima
                                </button>
                                <button type="button" wire:click="closeModalPiutang"
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
