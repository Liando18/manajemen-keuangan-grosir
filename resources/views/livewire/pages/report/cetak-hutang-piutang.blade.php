<div>
    <div class="mb-6">
        <h3 class="text-lg font-bold text-center text-gray-900">LAPORAN HUTANG PIUTANG</h3>
        {{-- <p class="text-center text-sm text-gray-700">
            Jenis: {{ $jenis ? ucfirst($jenis) : 'Semua' }}
            @if ($status)
                | Status: {{ ucfirst($status) }}
            @endif
        </p> --}}
    </div>

    <div class="overflow-x-auto">
        <table class="w-full" style="font-size: 10px; border: 2px solid #000; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f5f5f5;">
                    <th class="text-center py-2 px-2" style="width: 5%; border: 1px solid #000;">No</th>
                    <th class="text-center py-2 px-2" style="width: 12%; border: 1px solid #000;">Jenis</th>
                    <th class="text-center py-2 px-2" style="width: 20%; border: 1px solid #000;">Nama</th>
                    <th class="text-center py-2 px-2" style="width: 16%; border: 1px solid #000;">Total</th>
                    <th class="text-center py-2 px-2" style="width: 16%; border: 1px solid #000;">Terbayar</th>
                    <th class="text-center py-2 px-2" style="width: 16%; border: 1px solid #000;">Sisa</th>
                    <th class="text-center py-2 px-2" style="width: 15%; border: 1px solid #000;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $row)
                    <tr>
                        <td class="py-2 px-2 text-center" style="border: 1px solid #000;">{{ $row['no'] }}</td>
                        <td class="py-2 px-2 text-center" style="border: 1px solid #000;">{{ $row['jenis'] }}</td>
                        <td class="py-2 px-2" style="border: 1px solid #000;">{{ $row['nama'] }}</td>
                        <td class="py-2 px-2 text-right" style="border: 1px solid #000;">Rp
                            {{ $formatRupiah($row['total']) }}</td>
                        <td class="py-2 px-2 text-right" style="border: 1px solid #000;">Rp
                            {{ $formatRupiah($row['terbayar']) }}</td>
                        <td class="py-2 px-2 text-right" style="border: 1px solid #000;">Rp
                            {{ $formatRupiah($row['sisa']) }}</td>
                        <td class="py-2 px-2 text-center" style="border: 1px solid #000;">{{ ucfirst($row['status']) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center" style="border: 1px solid #000;">Belum ada data untuk
                            filter ini</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
