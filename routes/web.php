<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

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

    //AdminRoutes
    Route::middleware('role:admin')->group(function(){
        Route::get('/admin',[AdminController::class, 'dashboardAdmin'])->name('admin.dashboard');

        Route::get('/admin/dokter',[AdminController::class, 'showDokter'])->name('admin.dokter');
        Route::post('/admin/dokter',[AdminController::class, 'listDokter'])->name('admin.dokterList');
        Route::get('/admin/dokter/edit/{id}',[AdminController::class, 'editDokter'])->name('admin.dokterEdit');
        Route::put('/admin/dokter/update/{id}',[AdminController::class, 'updateDokter'])->name('admin.dokterUpdate');
        Route::delete('/admin/dokter/delete/{id}',[AdminController::class, 'destroyDokter'])->name('admin.dokterDelete');

        Route::get('/admin/pasien',[AdminController::class, 'showPasien'])->name('admin.pasien');
        Route::post('/admin/pasien',[AdminController::class, 'listPasien'])->name('admin.pasienList');
        Route::get('/admin/pasien/edit/{id}',[AdminController::class, 'editPasien'])->name('admin.pasienEdit');
        Route::put('/admin/pasien/update/{id}',[AdminController::class, 'updatePasien'])->name('admin.pasienUpdate');
        Route::delete('/admin/pasien/delete/{id}',[AdminController::class, 'destroyPasien'])->name('admin.pasienDelete');
        
        Route::get('/admin/poli',[AdminController::class, 'showPoli'])->name('admin.poli');
        Route::post('/admin/poli',[AdminController::class, 'listPoli'])->name('admin.poliList');
        Route::get('/admin/poli/edit/{id}',[AdminController::class, 'editPoli'])->name('admin.poliEdit');
        Route::put('/admin/poli/update/{id}',[AdminController::class, 'updatePoli'])->name('admin.poliUpdate');
        Route::delete('/admin/poli/delete/{id}',[AdminController::class, 'destroyPoli'])->name('admin.poliDelete');

        Route::get('/admin/obat', [AdminController::class, 'showObat'])->name('admin.obat');
        Route::post('/admin/obat', [AdminController::class, 'storeObat'])->name('admin.obatStore');
        Route::get('/admin/obat/edit/{id}', [AdminController::class, 'editObat'])->name('admin.obatEdit');
        Route::put('/admin/obat/update/{id}', [AdminController::class, 'updateObat'])->name('admin.obatUpdate');
        Route::delete('/admin/obat/delete/{id}', [AdminController::class, 'destroyObat'])->name('admin.obatDelete');
    });

});

// Route::get('/admin',[AdminController::class, 'dashboardAdmin'])->name('admin.dashboard');