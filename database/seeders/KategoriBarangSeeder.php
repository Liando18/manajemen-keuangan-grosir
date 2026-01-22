<?php

namespace Database\Seeders;

use App\Models\KategoriBarang;
use Illuminate\Database\Seeder;

class KategoriBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            // Makanan & Minuman
            [
                'nama' => 'Makanan Pokok',
                'keterangan' => 'Beras, tepung, gula, garam, dan bahan pokok lainnya',
            ],
            [
                'nama' => 'Minyak & Lemak',
                'keterangan' => 'Minyak goreng, mentega, margarin, dan produk lemak lainnya',
            ],
            [
                'nama' => 'Bumbu & Rempah',
                'keterangan' => 'Bumbu masak, rempah-rempah, saus, dan penyedap makanan',
            ],
            [
                'nama' => 'Minuman',
                'keterangan' => 'Air minum, minuman instan, teh, kopi, dan minuman kemasan',
            ],
            [
                'nama' => 'Snack & Cemilan',
                'keterangan' => 'Keripik, kacang, permen, cokelat, dan cemilan ringan',
            ],
            [
                'nama' => 'Makanan Kalengan & Beku',
                'keterangan' => 'Daging kalengan, ikan kalengan, sayur beku, dan produk kalengan lainnya',
            ],
            [
                'nama' => 'Susu & Produk Susu',
                'keterangan' => 'Susu cair, susu bubuk, keju, yogurt, dan produk susu lainnya',
            ],
            [
                'nama' => 'Daging & Seafood',
                'keterangan' => 'Daging segar, ikan segar, udang, dan produk seafood lainnya',
            ],
            [
                'nama' => 'Sayur & Buah Segar',
                'keterangan' => 'Sayuran segar, buah-buahan, dan tanaman segar lainnya',
            ],

            // Kebutuhan Sehari-hari
            [
                'nama' => 'Perawatan Pribadi',
                'keterangan' => 'Sabun, sampo, pasta gigi, deodoran, dan produk perawatan tubuh',
            ],
            [
                'nama' => 'Kecantikan & Kosmetik',
                'keterangan' => 'Makeup, skincare, lotion, dan produk kecantikan lainnya',
            ],
            [
                'nama' => 'Perawatan Pakaian',
                'keterangan' => 'Deterjen, pelembut pakaian, pemutih, dan pembersih pakaian',
            ],
            [
                'nama' => 'Perawatan Rumah',
                'keterangan' => 'Pembersih lantai, pengkilap, cairan pembersih, dan pembersih rumah',
            ],
            [
                'nama' => 'Pembersih & Desinfektan',
                'keterangan' => 'Disinfektan, pembasmi serangga, obat nyamuk, dan pestisida',
            ],

            // Kesehatan
            [
                'nama' => 'Obat & Vitamin',
                'keterangan' => 'Vitamin, suplemen, obat nyeri, dan produk kesehatan farmasi',
            ],
            [
                'nama' => 'Alat Kesehatan',
                'keterangan' => 'Termometer, tensimeter, perban, plaster, dan alat kesehatan lainnya',
            ],
            [
                'nama' => 'Perlengkapan Bayi',
                'keterangan' => 'Popok, susu bayi, baby wipes, dan perlengkapan bayi lainnya',
            ],

            // Barang Elektronik & Rumah Tangga
            [
                'nama' => 'Peralatan Dapur',
                'keterangan' => 'Wajan, panci, sendok, garpu, pisau, dan peralatan memasak',
            ],
            [
                'nama' => 'Peralatan Makan & Minum',
                'keterangan' => 'Piring, gelas, mangkuk, cangkir, teko, dan peralatan makan',
            ],
            [
                'nama' => 'Perlengkapan Rumah Tangga',
                'keterangan' => 'Sapu, kemoceng, serbet, handuk, lap, dan perlengkapan rumah',
            ],
            [
                'nama' => 'Furniture & Dekorasi',
                'keterangan' => 'Kursi, meja, rak, lemari, hiasan, dan dekorasi rumah',
            ],
            [
                'nama' => 'Elektronik Rumah Tangga',
                'keterangan' => 'Kulkas, rice cooker, blender, setrika, dan alat elektronik rumah',
            ],
            [
                'nama' => 'Lighting & Lampu',
                'keterangan' => 'Lampu LED, bohlam, neon, flashlight, dan penerangan',
            ],

            // Tekstil & Fashion
            [
                'nama' => 'Pakaian',
                'keterangan' => 'Baju, celana, rok, jaket, sweater, dan pakaian lainnya',
            ],
            [
                'nama' => 'Sepatu & Alas Kaki',
                'keterangan' => 'Sepatu olahraga, sandal, flip flop, dan alas kaki lainnya',
            ],
            [
                'nama' => 'Aksesori Fashion',
                'keterangan' => 'Topi, syal, ikat pinggang, tas, dan aksesori fashion',
            ],
            [
                'nama' => 'Tekstil & Kain',
                'keterangan' => 'Kain, sprei, bantal, selimut, gorden, dan produk tekstil',
            ],

            // Alat Tulis & Kantor
            [
                'nama' => 'Alat Tulis',
                'keterangan' => 'Pena, pensil, pensil warna, penghapus, dan alat tulis',
            ],
            [
                'nama' => 'Kertas & Buku',
                'keterangan' => 'Kertas HVS, kertas warna, buku tulis, buku kotak, dan kertas',
            ],
            [
                'nama' => 'Perlengkapan Kantor',
                'keterangan' => 'Stapler, lidi, klip, map, folder, dan perlengkapan kantor',
            ],

            // Olahraga & Outdoor
            [
                'nama' => 'Peralatan Olahraga',
                'keterangan' => 'Bola, raket, tali, helm, dan peralatan olahraga lainnya',
            ],
            [
                'nama' => 'Perlengkapan Outdoor & Camping',
                'keterangan' => 'Tenda, sleeping bag, ransel, dan perlengkapan outdoor',
            ],

            // Mainan & Hobi
            [
                'nama' => 'Mainan Anak',
                'keterangan' => 'Boneka, mobil mainan, puzzle, dan mainan anak-anak',
            ],
            [
                'nama' => 'Permainan & Hobi',
                'keterangan' => 'Board game, kartu, mainan edukatif, dan hobi lainnya',
            ],

            // Otomotif & Aksesoris
            [
                'nama' => 'Aksesori Mobil & Motor',
                'keterangan' => 'Aki, oli, ban, helm, jaket motor, dan aksesori otomotif',
            ],
            [
                'nama' => 'Suku Cadang',
                'keterangan' => 'Spare part mobil, motor, dan komponen otomotif lainnya',
            ],

            // Pet & Hewan Peliharaan
            [
                'nama' => 'Pakan Hewan Peliharaan',
                'keterangan' => 'Makanan anjing, kucing, burung, ikan, dan pakan hewan',
            ],
            [
                'nama' => 'Aksesori Hewan Peliharaan',
                'keterangan' => 'Kandang, mainan hewan, leash, collar, dan aksesori pet',
            ],

            // Produk Lainnya
            [
                'nama' => 'Hardware & Bangunan',
                'keterangan' => 'Paku, sekrup, kunci, cat, kabel, dan material bangunan',
            ],
            [
                'nama' => 'Pembungkus & Kemasan',
                'keterangan' => 'Plastik, tas kresek, kotak, tape, dan kemasan',
            ],
            [
                'nama' => 'Rokok & Tembakau',
                'keterangan' => 'Rokok, cerutu, tembakau, dan produk tembakau lainnya',
            ],
        ];

        foreach ($kategoris as $kategori) {
            KategoriBarang::create($kategori);
        }
    }
}
