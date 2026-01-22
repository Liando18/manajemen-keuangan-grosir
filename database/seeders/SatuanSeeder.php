<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $satuans = [
            // Satuan Berat
            [
                'nama' => 'Kilogram',
                'singkatan' => 'kg',
                'keterangan' => 'Satuan berat metrik standar internasional',
            ],
            [
                'nama' => 'Gram',
                'singkatan' => 'g',
                'keterangan' => 'Satuan berat metrik untuk item kecil',
            ],
            [
                'nama' => 'Miligram',
                'singkatan' => 'mg',
                'keterangan' => 'Satuan berat metrik untuk item sangat kecil',
            ],
            [
                'nama' => 'Ton',
                'singkatan' => 't',
                'keterangan' => 'Satuan berat besar setara 1000 kilogram',
            ],

            // Satuan Volume/Isi
            [
                'nama' => 'Liter',
                'singkatan' => 'L',
                'keterangan' => 'Satuan volume untuk cairan',
            ],
            [
                'nama' => 'Mililiter',
                'singkatan' => 'mL',
                'keterangan' => 'Satuan volume untuk cairan dalam jumlah kecil',
            ],
            [
                'nama' => 'Galon',
                'singkatan' => 'gal',
                'keterangan' => 'Satuan volume besar untuk cairan',
            ],
            [
                'nama' => 'Kubik Meter',
                'singkatan' => 'm³',
                'keterangan' => 'Satuan volume besar untuk ruang atau gas',
            ],

            // Satuan Panjang
            [
                'nama' => 'Meter',
                'singkatan' => 'm',
                'keterangan' => 'Satuan panjang standar internasional',
            ],
            [
                'nama' => 'Sentimeter',
                'singkatan' => 'cm',
                'keterangan' => 'Satuan panjang untuk ukuran kecil',
            ],
            [
                'nama' => 'Millimeter',
                'singkatan' => 'mm',
                'keterangan' => 'Satuan panjang untuk ukuran sangat kecil',
            ],
            [
                'nama' => 'Kilometer',
                'singkatan' => 'km',
                'keterangan' => 'Satuan panjang untuk jarak jauh',
            ],

            // Satuan Hitung
            [
                'nama' => 'Buah',
                'singkatan' => 'bh',
                'keterangan' => 'Satuan hitung untuk item satuan',
            ],
            [
                'nama' => 'Dus',
                'singkatan' => 'dus',
                'keterangan' => 'Satuan hitung untuk kemasan kardus',
            ],
            [
                'nama' => 'Pak',
                'singkatan' => 'pak',
                'keterangan' => 'Satuan hitung untuk kemasan paket',
            ],
            [
                'nama' => 'Lusin',
                'singkatan' => 'lsn',
                'keterangan' => 'Satuan hitung setara 12 buah',
            ],
            [
                'nama' => 'Gross',
                'singkatan' => 'grs',
                'keterangan' => 'Satuan hitung setara 144 buah',
            ],
            [
                'nama' => 'Rim',
                'singkatan' => 'rim',
                'keterangan' => 'Satuan hitung untuk kertas setara 500 lembar',
            ],
            [
                'nama' => 'Rol',
                'singkatan' => 'rol',
                'keterangan' => 'Satuan hitung untuk barang berbentuk gulungan',
            ],

            // Satuan Khusus
            [
                'nama' => 'Pasang',
                'singkatan' => 'psng',
                'keterangan' => 'Satuan untuk barang yang digunakan berpasangan',
            ],
            [
                'nama' => 'Set',
                'singkatan' => 'set',
                'keterangan' => 'Satuan hitung untuk kumpulan barang',
            ],
            [
                'nama' => 'Potong',
                'singkatan' => 'ptg',
                'keterangan' => 'Satuan untuk barang yang dipotong',
            ],
            [
                'nama' => 'Lembar',
                'singkatan' => 'lbr',
                'keterangan' => 'Satuan untuk barang pipih seperti kertas',
            ],
            [
                'nama' => 'Tangkai',
                'singkatan' => 'tng',
                'keterangan' => 'Satuan untuk bunga, tanaman, atau barang bertangkai',
            ],
            [
                'nama' => 'Batang',
                'singkatan' => 'btg',
                'keterangan' => 'Satuan untuk barang berbentuk batang',
            ],

            // Satuan Area
            [
                'nama' => 'Meter Persegi',
                'singkatan' => 'm²',
                'keterangan' => 'Satuan luas untuk area atau permukaan',
            ],
            [
                'nama' => 'Hektar',
                'singkatan' => 'ha',
                'keterangan' => 'Satuan luas besar setara 10000 meter persegi',
            ],

            // Satuan Grosir Khusus
            [
                'nama' => 'Bungkus',
                'singkatan' => 'bks',
                'keterangan' => 'Satuan untuk produk yang dibungkus/dikemas (rokok, cokelat, permen)',
            ],
            [
                'nama' => 'Slop',
                'singkatan' => 'slp',
                'keterangan' => 'Satuan grosir rokok: 1 slop = 10 bungkus',
            ],
            [
                'nama' => 'Bal',
                'singkatan' => 'bal',
                'keterangan' => 'Satuan untuk barang yang dibungkus dalam jumlah besar',
            ],
            [
                'nama' => 'Karton',
                'singkatan' => 'krt',
                'keterangan' => 'Satuan untuk produk dalam kemasan karton besar',
            ],
            [
                'nama' => 'Palet',
                'singkatan' => 'plt',
                'keterangan' => 'Satuan untuk barang dalam jumlah sangat besar di atas palet',
            ],
            [
                'nama' => 'Box',
                'singkatan' => 'box',
                'keterangan' => 'Satuan untuk produk dalam kemasan kotak',
            ],
            [
                'nama' => 'Garnis',
                'singkatan' => 'grn',
                'keterangan' => 'Satuan untuk produk fashion/tekstil dalam satu paket',
            ],
            [
                'nama' => 'Jampul',
                'singkatan' => 'jml',
                'keterangan' => 'Satuan untuk barang yang dijual dalam satu jampul/paket',
            ],
            [
                'nama' => 'Depa',
                'singkatan' => 'dpa',
                'keterangan' => 'Satuan panjang tradisional untuk kain atau tekstil',
            ],
            [
                'nama' => 'Yard',
                'singkatan' => 'yd',
                'keterangan' => 'Satuan panjang untuk tekstil dan kain',
            ],
            [
                'nama' => 'Inchi',
                'singkatan' => 'in',
                'keterangan' => 'Satuan panjang untuk ukuran layar atau elektronik',
            ],
            [
                'nama' => 'Ons',
                'singkatan' => 'oz',
                'keterangan' => 'Satuan berat tradisional untuk barang grosir',
            ],
            [
                'nama' => 'Pond',
                'singkatan' => 'pnd',
                'keterangan' => 'Satuan berat tradisional',
            ],
            [
                'nama' => 'Toples',
                'singkatan' => 'tpl',
                'keterangan' => 'Satuan untuk produk dalam kemasan toples',
            ],
            [
                'nama' => 'Botol',
                'singkatan' => 'btl',
                'keterangan' => 'Satuan untuk produk dalam kemasan botol',
            ],
            [
                'nama' => 'Kaleng',
                'singkatan' => 'kln',
                'keterangan' => 'Satuan untuk produk dalam kemasan kaleng',
            ],
            [
                'nama' => 'Tube',
                'singkatan' => 'tub',
                'keterangan' => 'Satuan untuk produk dalam kemasan tube (pasta gigi, dll)',
            ],
            [
                'nama' => 'Sachet',
                'singkatan' => 'sct',
                'keterangan' => 'Satuan untuk produk dalam kemasan sachet/kecil',
            ],
            [
                'nama' => 'Pouch',
                'singkatan' => 'pch',
                'keterangan' => 'Satuan untuk produk dalam kemasan pouch',
            ],
        ];

        foreach ($satuans as $satuan) {
            Satuan::create($satuan);
        }
    }
}
