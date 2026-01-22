<div>
    <div class="p-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Laporan Pengeluaran</h2>
            <p class="text-gray-600 mt-2">Analisis pengeluaran berdasarkan periode yang dipilih</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-end justify-between">
                <div class="flex gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Laporan</label>
                        <select wire:model.live="filterType"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                            <option value="hari">Per Hari</option>
                            <option value="bulan">Per Bulan</option>
                            <option value="tahun">Per Tahun</option>
                        </select>
                    </div>

                    @if ($filterType === 'hari')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Tanggal</label>
                            <input type="date" wire:model.live="tanggal"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                        </div>
                    @elseif ($filterType === 'bulan')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Bulan</label>
                            <select wire:model.live="bulan"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                        {{ \Carbon\Carbon::createFromFormat('m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Tahun</label>
                            <input type="number" wire:model.live="tahun" min="2020" max="{{ now()->year }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Tahun</label>
                            <input type="number" wire:model.live="tahunFilter" min="2020" max="{{ now()->year }}"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                        </div>
                    @endif
                </div>

                <div>
                    <a href="{{ route('laporan.pengeluaran.cetak', ['type' => $filterType, 'tanggal' => $tanggal, 'bulan' => $bulan, 'tahun' => $tahun, 'tahunFilter' => $tahunFilter]) }}"
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
                            @if ($filterType === 'hari')
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">No</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Waktu</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Sumber</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Keterangan</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Jumlah Uang</th>
                            @elseif ($filterType === 'bulan')
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">No</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Minggu Ke</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Jumlah Uang</th>
                            @else
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">No</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Bulan</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Jumlah Uang</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $row)
                            @if ($filterType === 'hari')
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="py-4 px-4 text-sm text-gray-900">{{ $row['no'] }}</td>
                                    <td class="py-4 px-4 text-sm text-gray-900">{{ $row['waktu'] }}</td>
                                    <td class="py-4 px-4 text-sm">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ $row['sumber'] }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-sm text-gray-600">
                                        @if (!empty($row['items']))
                                            <div class="space-y-3">
                                                @foreach ($row['items'] as $item)
                                                    <div class="bg-gray-50 p-3 rounded border border-gray-200">
                                                        <div class="font-medium text-gray-900">
                                                            {{ $item['barang_nama'] }}</div>
                                                        <div class="text-xs text-gray-600 mt-1 space-y-1">
                                                            <div>Jumlah: <span
                                                                    class="font-semibold">{{ $item['jumlah'] }}
                                                                    {{ $item['satuan'] }}</span></div>
                                                            <div>Harga Satuan: <span class="font-semibold">Rp
                                                                    {{ $formatRupiah($item['harga']) }}</span></div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-gray-500">{{ $row['keterangan'] ?? '-' }}</div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <span class="text-sm font-bold text-red-600">-Rp
                                            {{ $formatRupiah($row['jumlah']) }}</span>
                                    </td>
                                </tr>
                            @else
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="py-4 px-4 text-sm text-gray-900">{{ $row['no'] }}</td>
                                    <td class="py-4 px-4 text-sm text-gray-900 font-medium">
                                        {{ $row['periode'] ?? $row['bulan'] }}</td>
                                    <td class="py-4 px-4 text-right">
                                        <span class="text-sm font-bold text-red-600">-Rp
                                            {{ $formatRupiah($row['jumlah']) }}</span>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="{{ $filterType === 'hari' ? '5' : '3' }}"
                                    class="py-8 text-center text-gray-500">
                                    Belum ada data untuk periode ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-gray-200 bg-gray-50">
                            @if ($filterType === 'hari')
                                <td colspan="4" class="py-4 px-4 text-sm font-bold text-gray-900">Total Pengeluaran
                                </td>
                            @else
                                <td colspan="2" class="py-4 px-4 text-sm font-bold text-gray-900">Total Pengeluaran
                                </td>
                            @endif
                            <td class="py-4 px-4 text-right">
                                <span class="text-sm font-bold text-red-600">-Rp
                                    {{ $formatRupiah($totalPengeluaran) }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
