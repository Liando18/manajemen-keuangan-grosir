<div>
    <div class="mb-6">
        <h3 class="text-lg font-bold text-center text-gray-900">LAPORAN PENGELUARAN</h3>
        <p class="text-center text-sm text-gray-700">
            @if ($filterType === 'hari')
                Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
            @elseif($filterType === 'bulan')
                Periode: {{ \Carbon\Carbon::createFromFormat('m', $bulan)->translatedFormat('F') }} {{ $tahun }}
            @else
                Periode: Tahun {{ $tahunFilter }}
            @endif
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full" style="font-size: 10px; border: 2px solid #000; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f5f5f5;">
                    @if ($filterType === 'hari')
                        <th class="text-center py-2 px-2" style="width: 5%; border: 1px solid #000;">No</th>
                        <th class="text-center py-2 px-2" style="width: 10%; border: 1px solid #000;">Waktu</th>
                        <th class="text-center py-2 px-2" style="width: 15%; border: 1px solid #000;">Sumber</th>
                        <th class="text-center py-2 px-2" style="width: 55%; border: 1px solid #000;">Keterangan</th>
                        <th class="text-center py-2 px-2" style="width: 15%; border: 1px solid #000;">Jumlah Uang</th>
                    @elseif ($filterType === 'bulan')
                        <th class="text-center py-2 px-2" style="width: 10%; border: 1px solid #000;">No</th>
                        <th class="text-center py-2 px-2" style="width: 65%; border: 1px solid #000;">Minggu Ke</th>
                        <th class="text-center py-2 px-2" style="width: 25%; border: 1px solid #000;">Jumlah Uang</th>
                    @else
                        <th class="text-center py-2 px-2" style="width: 10%; border: 1px solid #000;">No</th>
                        <th class="text-center py-2 px-2" style="width: 65%; border: 1px solid #000;">Bulan</th>
                        <th class="text-center py-2 px-2" style="width: 25%; border: 1px solid #000;">Jumlah Uang</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $row)
                    @if ($filterType === 'hari')
                        <tr>
                            <td class="py-2 px-2 text-center" style="border: 1px solid #000;">{{ $row['no'] }}</td>
                            <td class="py-2 px-2 text-center" style="border: 1px solid #000;">{{ $row['waktu'] }}</td>
                            <td class="py-2 px-2" style="border: 1px solid #000;">{{ $row['sumber'] }}</td>
                            <td class="py-2 px-2" style="border: 1px solid #000;">
                                @if (!empty($row['items']))
                                    @foreach ($row['items'] as $index => $item)
                                        @if ($index > 0)
                                            <div style="border-top: 1px solid #ccc; margin: 4px 0 4px 0;"></div>
                                        @endif
                                        <div style="line-height: 1.4;">
                                            <strong>{{ $item['barang_nama'] }}</strong><br>
                                            Jumlah: {{ $item['jumlah'] }} {{ $item['satuan'] }}<br>
                                            Harga: Rp {{ $formatRupiah($item['harga']) }}
                                        </div>
                                    @endforeach
                                @else
                                    <div style="line-height: 1.4;">{{ $row['keterangan'] ?? '-' }}</div>
                                @endif
                            </td>
                            <td class="py-2 px-2 text-right" style="border: 1px solid #000;">
                                Rp {{ $formatRupiah($row['jumlah']) }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="py-2 px-2 text-center" style="border: 1px solid #000;">{{ $row['no'] }}</td>
                            <td class="py-2 px-2" style="border: 1px solid #000;">
                                {{ $row['periode'] ?? $row['bulan'] }}</td>
                            <td class="py-2 px-2 text-right" style="border: 1px solid #000;">Rp
                                {{ $formatRupiah($row['jumlah']) }}</td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="{{ $filterType === 'hari' ? '5' : '3' }}" class="py-4 text-center"
                            style="border: 1px solid #000;">Belum ada data untuk periode ini</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #f5f5f5;">
                    @if ($filterType === 'hari')
                        <td colspan="4" class="py-2 px-2 font-bold text-left" style="border: 1px solid #000;">Total
                            Pengeluaran</td>
                    @else
                        <td colspan="2" class="py-2 px-2 font-bold text-left" style="border: 1px solid #000;">Total
                            Pengeluaran</td>
                    @endif
                    <td class="py-2 px-2 text-right font-bold" style="border: 1px solid #000;">Rp
                        {{ $formatRupiah($totalPengeluaran) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
