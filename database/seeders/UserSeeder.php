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
                'alamat' => 'Pati',
                'no_hp' => '0812345678999',
                'no_ktp' => null,
                'no_rm' => null,
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'id_poli' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dr. Bagus',
                'alamat' => 'Pati',
                'no_hp' => '0812378123132',
                'no_ktp' => null,
                'no_rm' => null,
                'email' => 'bagus@gmail.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'id_poli' => 1, // Contoh id_poli (referensi ke poli)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dr. Andika',
                'alamat' => 'Surabaya',
                'no_hp' => '08123450002',
                'no_ktp' => null,
                'no_rm' => null,
                'email' => 'andika@gmail.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'id_poli' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi',
                'alamat' => 'Semarang',
                'no_hp' => '0812376793132',
                'no_ktp' => '3201011111000001',
                'no_rm' => 'RM0001',
                'email' => 'budi@gmail.com',
                'password' => Hash::make('pasien123'),
                'role' => 'pasien',
                'id_poli' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Joko',
                'alamat' => 'Semarang',
                'no_hp' => '08122220002',
                'no_ktp' => '3201011111000002',
                'no_rm' => 'RM00002',
                'email' => 'joko@gmail.com',
                'password' => Hash::make('pasien123'),
                'role' => 'pasien',
                'id_poli' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
