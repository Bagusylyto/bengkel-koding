<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama' => 'admin',
                'alamat' => 'Semarang',
                'no_hp' => '0812345678999',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin'
            ],
            [
                'nama' => 'dr. Agus',
                'alamat' => 'Semarang',
                'no_hp' => '0812378123132',
                'email' => 'agus.dokter@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'dokter'
            ],
            [
                'nama' => 'dr. Herry',
                'alamat' => 'Semarang',
                'no_hp' => '0812378123666',
                'email' => 'herry.dokter@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'dokter'
            ],
            [
                'nama' => 'Budi',
                'alamat' => 'Semarang',
                'no_hp' => '0812376793132',
                'email' => 'budi.pasien@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'pasien'
            ],
            [
                'nama' => 'Bagus',
                'alamat' => 'Semarang',
                'no_hp' => '0812345678910',
                'email' => 'bagus.pasien@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'pasien'
            ]
        ]);
    }
}
