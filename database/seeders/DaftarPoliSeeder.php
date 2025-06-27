<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DaftarPoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Ambil user pasien dan jadwal
        $pasien_ids = DB::table('users')->where('role', 'pasien')->pluck('id')->toArray();
        $jadwal_ids = DB::table('jadwal_periksa')->pluck('id')->toArray();

        // Cek jika tidak cukup data
        if (count($pasien_ids) < 2 || count($jadwal_ids) < 2) {
            $this->command->warn('DaftarPoliSeeder memerlukan minimal 2 pasien di tabel users dan 2 jadwal di tabel jadwal_periksa.');
            return;
        }
        DB::table('daftar_poli')->insert([

            [
                'id_pasien' => $pasien_ids[0],
                'id_jadwal' => $jadwal_ids[0],
                'keluhan' => $faker->sentence,
                'no_antrian' => 1,
                // 'status' => 'menunggu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_pasien' => $pasien_ids[1] ?? $pasien_ids[0],
                'id_jadwal' => $jadwal_ids[1] ?? $pasien_ids[0],
                'keluhan' => $faker->sentence,
                'no_antrian' => 2,
                // 'status' => 'menunggu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
