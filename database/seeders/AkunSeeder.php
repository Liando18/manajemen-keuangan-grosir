<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkunSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('akun')->insert([
            [
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'nama' => 'Admin Sistem',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'kasir@gmail.com',
                'password' => Hash::make('123'),
                'nama' => 'Kasir',
                'role' => 'kasir',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'pemilik@gmail.com',
                'password' => Hash::make('123'),
                'nama' => 'Pemilik Usaha',
                'role' => 'pemilik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'bendahara@gmail.com',
                'password' => Hash::make('123'),
                'nama' => 'Bendahara',
                'role' => 'bendahara',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'gudang@gmail.com',
                'password' => Hash::make('123'),
                'nama' => 'Petugas Gudang',
                'role' => 'gudang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
