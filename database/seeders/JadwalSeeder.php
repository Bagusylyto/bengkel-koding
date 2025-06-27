<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // Ambil user dokter
        $dokter_ids = DB::table('users')->where('role', 'dokter')->pluck('id')->toArray();

        // Cek jika tidak cukup data
        if (count($dokter_ids) < 2) {
            $this->command->warn('Seeder memerlukan minimal 2 dokter di tabel users.');
            return;
        }

        // Seed jadwal_periksa table
        $jadwal = [
            [
                'id_dokter' => $dokter_ids[0],
                'hari' => 'Senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dokter' => $dokter_ids[1],
                'hari' => 'Selasa',
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '13:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($jadwal as $data) {
            DB::table('jadwal_periksa')->insert($data);
        }
    }
}
