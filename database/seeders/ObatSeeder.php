<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('obat')->insert([
            [
                'nama_obat' => 'Paracetamol 500mg',
                'kemasan' => 'Tablet',
                'harga' => 5000
            ],
            [
                'nama_obat' => 'Amoxicillin 500mg',
                'kemasan' => 'Kapsul',
                'harga' => 8000
            ],
            [
                'nama_obat' => 'OBH Combi',
                'kemasan' => 'Sirup 60ml',
                'harga' => 12000
            ],
            [
                'nama_obat' => 'Antasida DOEN',
                'kemasan' => 'Tablet',
                'harga' => 3000
            ],
            [
                'nama_obat' => 'Vitamin C 500mg',
                'kemasan' => 'Tablet',
                'harga' => 2000
            ]
        ]);
    }
}
