<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PoliSeeder::class,
            JadwalSeeder::class,
            ObatSeeder::class,
            DaftarPoliSeeder::class,
            PeriksaSeeder::class,
            DetailPeriksaSeeder::class
        ]);
    }
}
