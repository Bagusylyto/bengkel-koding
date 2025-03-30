<?php

use Illuminate\Support\Facades\Route;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use App\Models\Obat;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/dokter', function () {
    $periksas = Periksa::all(); 
    $obats = Obat::all(); 
    return view('dokter.dashboard', compact('periksas', 'obats'));
});

Route::get('/dokter/obat', function () {
    $obats = Obat::all(); 
    return view('dokter.obat', compact('obats'));
});

Route::get('/dokter/periksa', function () {
    $periksas = Periksa::all(); 
    $obats = Obat::all();
    return view('dokter.periksa', compact('periksas', 'obats'));
});



Route::get('/pasien', function () {
    $periksas = Periksa::all(); 
    return view('pasien.dashboard', compact('periksas'));
});
Route::get('/pasien/periksa', function () {
    $periksas = Periksa::all(); 
    return view('pasien.periksa', compact('periksas'));
});

Route::get('/pasien/riwayat', function () {
    $Detailperiksas = DetailPeriksa::all(); 
    $periksas = Periksa::all();
    return view('pasien.riwayat', compact('Detailperiksas', 'periksas'));
});