<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Satuan;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get kategori dan satuan IDs
        $kategoris = KategoriBarang::pluck('id', 'nama');
        $satuans = Satuan::pluck('id', 'singkatan');

        $barangs = [
            // Makanan Pokok
            [
                'kategori_id' => $kategoris['Makanan Pokok'],
                'satuan_id' => $satuans['kg'],
                'nama' => 'Beras Premium 5kg',
                'harga' => 65000.00,
            ],
            [
                'kategori_id' => $kategoris['Makanan Pokok'],
                'satuan_id' => $satuans['kg'],
                'nama' => 'Beras Biasa 5kg',
                'harga' => 50000.00,
            ],
            [
                'kategori_id' => $kategoris['Makanan Pokok'],
                'satuan_id' => $satuans['kg'],
                'nama' => 'Tepung Terigu 1kg',
                'harga' => 8000.00,
            ],
            [
                'kategori_id' => $kategoris['Makanan Pokok'],
                'satuan_id' => $satuans['kg'],
                'nama' => 'Gula Pasir 1kg',
                'harga' => 11000.00,
            ],
            [
                'kategori_id' => $kategoris['Makanan Pokok'],
                'satuan_id' => $satuans['kg'],
                'nama' => 'Garam Halus 1kg',
                'harga' => 3500.00,
            ],

            // Minyak & Lemak
            [
                'kategori_id' => $kategoris['Minyak & Lemak'],
                'satuan_id' => $satuans['L'],
                'nama' => 'Minyak Goreng 2L',
                'harga' => 24000.00,
            ],
            [
                'kategori_id' => $kategoris['Minyak & Lemak'],
                'satuan_id' => $satuans['L'],
                'nama' => 'Minyak Goreng 1L',
                'harga' => 12500.00,
            ],
            [
                'kategori_id' => $kategoris['Minyak & Lemak'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Margarin 200gr',
                'harga' => 5500.00,
            ],

            // Bumbu & Rempah
            [
                'kategori_id' => $kategoris['Bumbu & Rempah'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Bumbu Masak Instan',
                'harga' => 2500.00,
            ],
            [
                'kategori_id' => $kategoris['Bumbu & Rempah'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Kecap Manis 625ml',
                'harga' => 8000.00,
            ],
            [
                'kategori_id' => $kategoris['Bumbu & Rempah'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Sambal Botol 300ml',
                'harga' => 6500.00,
            ],

            // Minuman
            [
                'kategori_id' => $kategoris['Minuman'],
                'satuan_id' => $satuans['dus'],
                'nama' => 'Air Mineral 600ml x24',
                'harga' => 52000.00,
            ],
            [
                'kategori_id' => $kategoris['Minuman'],
                'satuan_id' => $satuans['dus'],
                'nama' => 'Teh Botol 200ml x24',
                'harga' => 48000.00,
            ],
            [
                'kategori_id' => $kategoris['Minuman'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Kopi Instan Sachet',
                'harga' => 1200.00,
            ],
            [
                'kategori_id' => $kategoris['Minuman'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Mie Instan x5',
                'harga' => 9000.00,
            ],

            // Snack & Cemilan
            [
                'kategori_id' => $kategoris['Snack & Cemilan'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Keripik Singkong 75gr',
                'harga' => 3500.00,
            ],
            [
                'kategori_id' => $kategoris['Snack & Cemilan'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Permen Lolipop x10',
                'harga' => 8000.00,
            ],
            [
                'kategori_id' => $kategoris['Snack & Cemilan'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Cokelat Batangan 25gr',
                'harga' => 4500.00,
            ],
            [
                'kategori_id' => $kategoris['Snack & Cemilan'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Wafer Cokelat 100gr',
                'harga' => 2800.00,
            ],

            // Makanan Kalengan & Beku
            [
                'kategori_id' => $kategoris['Makanan Kalengan & Beku'],
                'satuan_id' => $satuans['kln'],
                'nama' => 'Daging Kalengan 150gr',
                'harga' => 18000.00,
            ],
            [
                'kategori_id' => $kategoris['Makanan Kalengan & Beku'],
                'satuan_id' => $satuans['kln'],
                'nama' => 'Ikan Tuna Kalengan 180gr',
                'harga' => 12000.00,
            ],

            // Susu & Produk Susu
            [
                'kategori_id' => $kategoris['Susu & Produk Susu'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Susu Cair UHT 200ml',
                'harga' => 3500.00,
            ],
            [
                'kategori_id' => $kategoris['Susu & Produk Susu'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Susu Bubuk 400gr',
                'harga' => 42000.00,
            ],
            [
                'kategori_id' => $kategoris['Susu & Produk Susu'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Keju Slice 200gr',
                'harga' => 28000.00,
            ],

            // Perawatan Pribadi
            [
                'kategori_id' => $kategoris['Perawatan Pribadi'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Sabun Mandi Batang',
                'harga' => 3000.00,
            ],
            [
                'kategori_id' => $kategoris['Perawatan Pribadi'],
                'satuan_id' => $satuans['btl'],
                'nama' => 'Sabun Cair 250ml',
                'harga' => 8500.00,
            ],
            [
                'kategori_id' => $kategoris['Perawatan Pribadi'],
                'satuan_id' => $satuans['btl'],
                'nama' => 'Sampo 200ml',
                'harga' => 7000.00,
            ],
            [
                'kategori_id' => $kategoris['Perawatan Pribadi'],
                'satuan_id' => $satuans['tub'],
                'nama' => 'Pasta Gigi Tube 100gr',
                'harga' => 5500.00,
            ],
            [
                'kategori_id' => $kategoris['Perawatan Pribadi'],
                'satuan_id' => $satuans['btl'],
                'nama' => 'Deodoran Roll On 50ml',
                'harga' => 12000.00,
            ],

            // Kecantikan & Kosmetik
            [
                'kategori_id' => $kategoris['Kecantikan & Kosmetik'],
                'satuan_id' => $satuans['btl'],
                'nama' => 'Facial Wash 100ml',
                'harga' => 15000.00,
            ],
            [
                'kategori_id' => $kategoris['Kecantikan & Kosmetik'],
                'satuan_id' => $satuans['btl'],
                'nama' => 'Moisturizer Lotion 150ml',
                'harga' => 25000.00,
            ],
            [
                'kategori_id' => $kategoris['Kecantikan & Kosmetik'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Lipstik Kosmetik',
                'harga' => 28000.00,
            ],

            // Perawatan Pakaian
            [
                'kategori_id' => $kategoris['Perawatan Pakaian'],
                'satuan_id' => $satuans['btl'],
                'nama' => 'Deterjen Cair 1L',
                'harga' => 18000.00,
            ],
            [
                'kategori_id' => $kategoris['Perawatan Pakaian'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Deterjen Bubuk 500gr',
                'harga' => 12000.00,
            ],
            [
                'kategori_id' => $kategoris['Perawatan Pakaian'],
                'satuan_id' => $satuans['btl'],
                'nama' => 'Pelembut Pakaian 1L',
                'harga' => 12000.00,
            ],

            // Perawatan Rumah
            [
                'kategori_id' => $kategoris['Perawatan Rumah'],
                'satuan_id' => $satuans['btl'],
                'nama' => 'Pembersih Lantai 1L',
                'harga' => 10000.00,
            ],
            [
                'kategori_id' => $kategoris['Perawatan Rumah'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Pengkilap Furnitur 500ml',
                'harga' => 14000.00,
            ],

            // Pembersih & Desinfektan
            [
                'kategori_id' => $kategoris['Pembersih & Desinfektan'],
                'satuan_id' => $satuans['btl'],
                'nama' => 'Disinfektan 500ml',
                'harga' => 22000.00,
            ],
            [
                'kategori_id' => $kategoris['Pembersih & Desinfektan'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Obat Nyamuk Bakar x10',
                'harga' => 25000.00,
            ],

            // Obat & Vitamin
            [
                'kategori_id' => $kategoris['Obat & Vitamin'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Vitamin C 500mg x10',
                'harga' => 8500.00,
            ],
            [
                'kategori_id' => $kategoris['Obat & Vitamin'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Obat Pusing Botol',
                'harga' => 5000.00,
            ],

            // Perlengkapan Bayi
            [
                'kategori_id' => $kategoris['Perlengkapan Bayi'],
                'satuan_id' => $satuans['pak'],
                'nama' => 'Popok Bayi isi 10',
                'harga' => 35000.00,
            ],
            [
                'kategori_id' => $kategoris['Perlengkapan Bayi'],
                'satuan_id' => $satuans['pak'],
                'nama' => 'Baby Wipes 80 sheet',
                'harga' => 12000.00,
            ],

            // Peralatan Dapur
            [
                'kategori_id' => $kategoris['Peralatan Dapur'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Wajan Anti Lengket 30cm',
                'harga' => 85000.00,
            ],
            [
                'kategori_id' => $kategoris['Peralatan Dapur'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Panci Stainless 20cm',
                'harga' => 95000.00,
            ],
            [
                'kategori_id' => $kategoris['Peralatan Dapur'],
                'satuan_id' => $satuans['set'],
                'nama' => 'Sendok Garpu Set 6pcs',
                'harga' => 25000.00,
            ],

            // Peralatan Makan & Minum
            [
                'kategori_id' => $kategoris['Peralatan Makan & Minum'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Piring Makan Keramik',
                'harga' => 8000.00,
            ],
            [
                'kategori_id' => $kategoris['Peralatan Makan & Minum'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Gelas Kaca 200ml',
                'harga' => 3500.00,
            ],
            [
                'kategori_id' => $kategoris['Peralatan Makan & Minum'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Mangkuk Keramik Besar',
                'harga' => 6500.00,
            ],

            // Perlengkapan Rumah Tangga
            [
                'kategori_id' => $kategoris['Perlengkapan Rumah Tangga'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Sapu Lidi Standar',
                'harga' => 8000.00,
            ],
            [
                'kategori_id' => $kategoris['Perlengkapan Rumah Tangga'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Kemoceng Bulu Ayam',
                'harga' => 15000.00,
            ],
            [
                'kategori_id' => $kategoris['Perlengkapan Rumah Tangga'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Serbet Linen 50x50cm',
                'harga' => 4000.00,
            ],

            // Furniture & Dekorasi
            [
                'kategori_id' => $kategoris['Furniture & Dekorasi'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Kursi Plastik Standar',
                'harga' => 95000.00,
            ],
            [
                'kategori_id' => $kategoris['Furniture & Dekorasi'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Meja Plastik Panjang',
                'harga' => 185000.00,
            ],

            // Elektronik Rumah Tangga
            [
                'kategori_id' => $kategoris['Elektronik Rumah Tangga'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Blender 2 in 1',
                'harga' => 285000.00,
            ],
            [
                'kategori_id' => $kategoris['Elektronik Rumah Tangga'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Rice Cooker 2L',
                'harga' => 325000.00,
            ],

            // Lighting & Lampu
            [
                'kategori_id' => $kategoris['Lighting & Lampu'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Lampu LED 9W Putih',
                'harga' => 22000.00,
            ],
            [
                'kategori_id' => $kategoris['Lighting & Lampu'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Bohlam Pijar 60W',
                'harga' => 8000.00,
            ],

            // Pakaian
            [
                'kategori_id' => $kategoris['Pakaian'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Kaos Polos Putih S-XL',
                'harga' => 35000.00,
            ],
            [
                'kategori_id' => $kategoris['Pakaian'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Celana Jeans Panjang',
                'harga' => 125000.00,
            ],

            // Sepatu & Alas Kaki
            [
                'kategori_id' => $kategoris['Sepatu & Alas Kaki'],
                'satuan_id' => $satuans['psng'],
                'nama' => 'Sepatu Olahraga Putih',
                'harga' => 185000.00,
            ],
            [
                'kategori_id' => $kategoris['Sepatu & Alas Kaki'],
                'satuan_id' => $satuans['psng'],
                'nama' => 'Sandal Jepit Plastik',
                'harga' => 12000.00,
            ],

            // Aksesori Fashion
            [
                'kategori_id' => $kategoris['Aksesori Fashion'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Topi Kasual Polos',
                'harga' => 45000.00,
            ],
            [
                'kategori_id' => $kategoris['Aksesori Fashion'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Ikat Pinggang Kulit',
                'harga' => 55000.00,
            ],

            // Tekstil & Kain
            [
                'kategori_id' => $kategoris['Tekstil & Kain'],
                'satuan_id' => $satuans['yd'],
                'nama' => 'Kain Katun Per Yard',
                'harga' => 35000.00,
            ],
            [
                'kategori_id' => $kategoris['Tekstil & Kain'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Sprei Katun 180x200cm',
                'harga' => 95000.00,
            ],

            // Alat Tulis
            [
                'kategori_id' => $kategoris['Alat Tulis'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Pena Ballpoint x12',
                'harga' => 18000.00,
            ],
            [
                'kategori_id' => $kategoris['Alat Tulis'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Pensil Grafir x12',
                'harga' => 15000.00,
            ],

            // Kertas & Buku
            [
                'kategori_id' => $kategoris['Kertas & Buku'],
                'satuan_id' => $satuans['rim'],
                'nama' => 'Kertas HVS A4 1 Rim',
                'harga' => 42000.00,
            ],
            [
                'kategori_id' => $kategoris['Kertas & Buku'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Buku Tulis 40 Halaman',
                'harga' => 8500.00,
            ],

            // Perlengkapan Kantor
            [
                'kategori_id' => $kategoris['Perlengkapan Kantor'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Stapler Besar',
                'harga' => 28000.00,
            ],
            [
                'kategori_id' => $kategoris['Perlengkapan Kantor'],
                'satuan_id' => $satuans['box'],
                'nama' => 'Klip Kertas Mix Warna',
                'harga' => 12000.00,
            ],

            // Peralatan Olahraga
            [
                'kategori_id' => $kategoris['Peralatan Olahraga'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Bola Voli Standar',
                'harga' => 125000.00,
            ],
            [
                'kategori_id' => $kategoris['Peralatan Olahraga'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Raket Badminton Set',
                'harga' => 185000.00,
            ],

            // Mainan Anak
            [
                'kategori_id' => $kategoris['Mainan Anak'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Boneka Teddy Bear',
                'harga' => 45000.00,
            ],
            [
                'kategori_id' => $kategoris['Mainan Anak'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Mobil Mainan Die Cast',
                'harga' => 35000.00,
            ],

            // Aksesori Otomotif
            [
                'kategori_id' => $kategoris['Aksesori Mobil & Motor'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Helm Standar Unisex',
                'harga' => 185000.00,
            ],
            [
                'kategori_id' => $kategoris['Aksesori Mobil & Motor'],
                'satuan_id' => $satuans['L'],
                'nama' => 'Oli Mobil 1L',
                'harga' => 35000.00,
            ],

            // Pakan Hewan Peliharaan
            [
                'kategori_id' => $kategoris['Pakan Hewan Peliharaan'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Makanan Anjing 1kg',
                'harga' => 42000.00,
            ],
            [
                'kategori_id' => $kategoris['Pakan Hewan Peliharaan'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Makanan Kucing 500gr',
                'harga' => 28000.00,
            ],

            // Hardware & Bangunan
            [
                'kategori_id' => $kategoris['Hardware & Bangunan'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Paku Besi 2 inch x1kg',
                'harga' => 18000.00,
            ],
            [
                'kategori_id' => $kategoris['Hardware & Bangunan'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Cat Tembok Putih 1kg',
                'harga' => 45000.00,
            ],

            // Pembungkus & Kemasan
            [
                'kategori_id' => $kategoris['Pembungkus & Kemasan'],
                'satuan_id' => $satuans['bks'],
                'nama' => 'Tas Kresek Plastik 100pcs',
                'harga' => 12000.00,
            ],
            [
                'kategori_id' => $kategoris['Pembungkus & Kemasan'],
                'satuan_id' => $satuans['bh'],
                'nama' => 'Tape Isolasi Bening',
                'harga' => 8000.00,
            ],

            // Rokok & Tembakau
            [
                'kategori_id' => $kategoris['Rokok & Tembakau'],
                'satuan_id' => $satuans['slp'],
                'nama' => 'Rokok Kretek Filter Slop',
                'harga' => 55000.00,
            ],
            [
                'kategori_id' => $kategoris['Rokok & Tembakau'],
                'satuan_id' => $satuans['slp'],
                'nama' => 'Rokok Putih Filter Slop',
                'harga' => 65000.00,
            ],
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang);
        }
    }
}
