<?php

use Illuminate\Support\Facades\Route;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

//Auth Routes

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('auth.login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'storeAkun'])->name('auth.register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout.post');

Route::get('/403', function () {
    return view('error.403');
})->name('auth.denied');

// Route::get('/login', function () {
//     return view('auth.login');
// });

// Route::get('/register', function () {
//     return view('auth.register');
// });


//Dokter Routes

// Route::get('/dokter', function () {
//     $periksas = Periksa::all(); 
//     $obats = Obat::all(); 
//     return view('dokter.dashboard', compact('periksas', 'obats'));
// });

// Route::get('/dokter/obat', function () {
//     $obats = Obat::all(); 
//     return view('dokter.obat', compact('obats'));
// });

// Route::get('/dokter/periksa', function () {
//     $periksas = Periksa::all(); 
//     $obats = Obat::all();
//     return view('dokter.periksa', compact('periksas', 'obats'));
// });


Route::middleware('auth')->group(function () {
    //DokterRoutes
    Route::middleware('role:dokter')->group(function () {
        Route::get('/dokter', [DokterController::class, 'dashboardDokter'])->name('dokter.dashboard');
        Route::get('/dokter/obat', [DokterController::class, 'showObat'])->name('dokter.obat');
        Route::post('/dokter/obat', [DokterController::class, 'storeObat'])->name('dokter.obatStore');
        Route::get('/dokter/obat/edit/{id}', [DokterController::class, 'editObat'])->name('dokter.obatEdit');
        Route::put('/dokter/obat/update/{id}', [DokterController::class, 'updateObat'])->name('dokter.obatUpdate');
        Route::delete('/dokter/obat/delete/{id}', [DokterController::class, 'destroyObat'])->name('dokter.obatDelete');
        Route::get('/dokter/periksa', [DokterController::class, 'showPeriksa'])->name('dokter.periksa');
        Route::get('/dokter/periksa/edit/{id}', [DokterController::class, 'editPeriksa'])->name('dokter.periksaEdit');
        Route::put('/dokter/periksa/update/{id}', [DokterController::class, 'updatePeriksa'])->name('dokter.periksaUpdate');
    });      

    //PasienRoutes

    Route::middleware('role:pasien')->group(function () {
        Route::get('/pasien', [PasienController::class, 'dashboardPasien'])->name('pasien.dashboard');
        Route::get('/pasien/riwayat', [PasienController::class, 'showPeriksas'])->name('pasien.riwayat');
        Route::get('/pasien/periksa', [PasienController::class, 'createPeriksa'])->name('pasien.periksa');
        Route::post('/pasien/periksa', [PasienController::class, 'storePeriksa'])->name('pasien.periksa.store');
    });

});
// Route::get('/dokter/periksa', function () {
//     $periksas = Periksa::all(); 
//     $obats = Obat::all();
//     return view('dokter.periksa', compact('periksas', 'obats'));
// })->name('dokter.periksa');

//Pasien

// Route::get('/pasien', function () {
//     return view('pasien.dashboard');
// })->name('pasien.dashboard');

// Route::get('/pasien/periksa', function () {
//     return view('pasien.periksa');
// })->name('pasien.periksa');

// Route::get('/pasien/riwayat', function () {
//     return view('pasien.riwayat');
// })->name('pasien.riwayat');


// Route::get('/pasien/riwayat/{id}', [PasienController::class, 'showDetailPeriksa'])->name('pasien.riwayatDetail');