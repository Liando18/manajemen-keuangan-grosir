<div>
    <div class="mb-6">
        <h3 class="text-lg font-bold text-center text-gray-900">LAPORAN STOK BARANG</h3>
        {{-- <p class="text-center text-sm text-gray-700">
            Tanggal Cetak: {{ now()->translatedFormat('d F Y') }}
            @if ($status)
                | Status: {{ $status }}
            @endif
        </p> --}}
    </div>

    <div class="overflow-x-auto">
        <table class="w-full" style="font-size: 10px; border: 2px solid #000; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f5f5f5;">
                    <th class="text-center py-2 px-2" style="width: 5%; border: 1px solid #000;">No</th>
                    <th class="text-center py-2 px-2" style="width: 12%; border: 1px solid #000;">Kategori</th>
                    <th class="text-center py-2 px-2" style="width: 22%; border: 1px solid #000;">Nama Barang</th>
                    <th class="text-center py-2 px-2" style="width: 10%; border: 1px solid #000;">Satuan</th>
                    <th class="text-center py-2 px-2" style="width: 14%; border: 1px solid #000;">Harga</th>
                    <th class="text-center py-2 px-2" style="width: 8%; border: 1px solid #000;">Stok</th>
                    <th class="text-center py-2 px-2" style="width: 18%; border: 1px solid #000;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $row)
                    <tr>
                        <td class="py-2 px-2 text-center" style="border: 1px solid #000;">{{ $row['no'] }}</td>
                        <td class="py-2 px-2" style="border: 1px solid #000;">{{ $row['kategori'] }}</td>
                        <td class="py-2 px-2" style="border: 1px solid #000;">{{ $row['barang_nama'] }}</td>
                        <td class="py-2 px-2 text-center" style="border: 1px solid #000;">{{ $row['satuan'] }}</td>
                        <td class="py-2 px-2 text-right" style="border: 1px solid #000;">Rp
                            {{ $formatRupiah($row['harga']) }}</td>
                        <td class="py-2 px-2 text-center" style="border: 1px solid #000;">{{ $row['stok'] }}</td>
                        <td class="py-2 px-2 text-center" style="border: 1px solid #000;">{{ $row['status'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center" style="border: 1px solid #000;">Belum ada data
                            barang</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
