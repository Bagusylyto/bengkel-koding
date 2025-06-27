<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPeriksaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periksa_ids = DB::table('periksa')->pluck('id')->toArray();
        $obat_ids = DB::table('obat')->pluck('id')->toArray();

        if (empty($periksa_ids) || empty($obat_ids)) {
            $this->command->warn('Seeder memerlukan data di tabel periksa dan obat.');
            return;
        }

        DB::table('detail_periksa')->insert([
            [
                'id_periksa' => $periksa_ids[0],
                'id_obat' => $obat_ids[0],
                'jumlah' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_periksa' => $periksa_ids[0],
                'id_obat' => $obat_ids[1],
                'jumlah' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_periksa' => $periksa_ids[1] ?? $periksa_ids[0],
                'id_obat' => $obat_ids[2] ?? $obat_ids[0],
                'jumlah' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
