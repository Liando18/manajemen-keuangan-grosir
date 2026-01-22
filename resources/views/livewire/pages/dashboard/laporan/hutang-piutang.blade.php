<div>
    <div class="p-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Laporan Hutang Piutang</h2>
            <p class="text-gray-600 mt-2">Kelola hutang kepada supplier dan piutang dari pelanggan</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis</label>
                    <select wire:model.live="jenis"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                        <option value="">Semua Jenis</option>
                        <option value="hutang">Hutang</option>
                        <option value="piutang">Piutang</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select wire:model.live="status"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                        <option value="">Semua Status</option>
                        <option value="belum">Belum Lunas</option>
                        <option value="lunas">Lunas</option>
                    </select>
                </div>

                <div>
                    <a href="{{ route('laporan.hutang-piutang.cetak', ['jenis' => $jenis, 'status' => $status]) }}"
                        target="_blank"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak Laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">No</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Jenis</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Nama</th>
                            <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Total</th>
                            <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Terbayar</th>
                            <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Sisa</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $row)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="py-4 px-4 text-sm text-gray-900">{{ $row['no'] }}</td>
                                <td class="py-4 px-4 text-sm">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium {{ $row['jenis'] === 'Hutang' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $row['jenis'] }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-900 font-medium">{{ $row['nama'] }}</td>
                                <td class="py-4 px-4 text-right">
                                    <span class="text-sm font-semibold text-gray-900">Rp
                                        {{ $formatRupiah($row['total']) }}</span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <span class="text-sm font-semibold text-green-600">Rp
                                        {{ $formatRupiah($row['terbayar']) }}</span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <span
                                        class="text-sm font-semibold {{ $row['sisa'] > 0 ? 'text-red-600' : 'text-green-600' }}">
                                        Rp {{ $formatRupiah($row['sisa']) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium {{ $row['status'] === 'lunas' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($row['status']) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-500">
                                    Belum ada data untuk filter ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
