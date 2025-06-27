<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PeriksaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Fetch valid IDs from daftar_poli, pasien, and dokter tables
        $daftar_poli_ids = DB::table('daftar_poli')->pluck('id')->toArray();
        $dokter_ids = DB::table('users')->where('role', 'dokter')->pluck('id')->toArray();
        $pasien_ids = DB::table('users')->where('role', 'pasien')->pluck('id')->toArray();

        // Check if required data exists
        if (empty($daftar_poli_ids) || empty($dokter_ids) || empty($pasien_ids)) {
            throw new \Exception('Required data in daftar_poli, pasien, or dokter tables is missing. Please seed those tables first.');
        }

        // Ensure we have valid IDs to use (fall back to first available IDs if 1 or 3 are not present)
       
        $id_daftar_poli = $daftar_poli_ids[0]; // Use the first available daftar_poli ID

        DB::table('periksa')->insert([
            [
                'id_daftar_poli' => $id_daftar_poli,
                'id_dokter' => $dokter_ids[0],
                'id_pasien' => $pasien_ids[0],
                'tgl_periksa' => '2025-03-23 12:00:00',
                'catatan' => 'Pasien mengalami demam tinggi dan sakit kepala',
                'biaya_periksa' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_daftar_poli' => $daftar_poli_ids[1] ?? $id_daftar_poli,
                'id_dokter' => $dokter_ids[1] ?? $dokter_ids[0],
                'id_pasien' => $pasien_ids[1] ?? $pasien_ids[0],
                'tgl_periksa' => '2025-03-23 15:00:00',
                'catatan' => 'Keluhan batuk berdahak dan pilek',
                'biaya_periksa' => 60000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
