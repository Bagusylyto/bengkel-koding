<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
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


Route::middleware('auth')->group(function () {
    //DokterRoutes
    Route::middleware('role:dokter')->group(function () {
        Route::get('/dokter', [DokterController::class, 'dashboardDokter'])->name('dokter.dashboard');

        Route::get('/dokter/obat', [DokterController::class, 'showObat'])->name('dokter.obat');

        Route::get('/dokter/jadwal', [DokterController::class, 'indexJadwal'])->name('dokter.jadwal');
        Route::get('/dokter/jadwal/add', [DokterController::class, 'addJadwal'])->name('dokter.jadwalAdd');
        Route::post('/dokter/jadwal', [DokterController::class, 'storeJadwal'])->name('dokter.jadwalStore');
        Route::get('/dokter/jadwal/edit/{id}', [DokterController::class, 'editJadwal'])->name('dokter.jadwalEdit');
        Route::put('/dokter/jadwal/update/{id}', [DokterController::class, 'updateJadwal'])->name('dokter.jadwalUpdate');

        Route::get('/dokter/periksa', [DokterController::class, 'indexPeriksa'])->name('dokter.periksa');
        Route::get('/dokter/periksa/{id_daftar_poli}', [DokterController::class, 'formPeriksa'])->name('dokter.periksaForm');
        Route::post('/dokter/periksa', [DokterController::class, 'storePeriksa'])->name('dokter.periksaStore'); 
        // Route::get('/dokter/create/{daftarPoli}', [DokterController::class, 'createPeriksa'])->name('dokter.periksaCreate');
        Route::get('/dokter/periksa/edit/{id_daftar_poli}', [DokterController::class, 'editPeriksa'])->name('dokter.periksaEdit');
        Route::put('/dokter/periksa/update/{id_daftar_poli}', [DokterController::class, 'updatePeriksa'])->name('dokter.periksaUpdate'); //untuk periksa pasien
        // Route::put('/dokter/periksa/update/{id}', [DokterController::class, 'updatePeriksa2'])->name('dokter.periksaUpdate2'); //untuk edit periksa pasien

        Route::get('/dokter/riwayat', [DokterController::class, 'indexRiwayat'])->name('dokter.riwayat');
        Route::get('/dokter/pasien/{id}/detail', [DokterController::class, 'riwayatDetail'])->name('dokter.riwayatDetail');

        Route::get('/dokter/profile', [DokterController::class, 'indexProfile'])->name('dokter.profile');
        Route::put('/dokter/profile', [DokterController::class, 'profileUpdate'])->name('dokter.profileUpdate');
    });      

    //PasienRoutes
    Route::middleware('role:pasien')->group(function () {
        Route::get('/pasien', [PasienController::class, 'dashboardPasien'])->name('pasien.dashboard');

        Route::get('/pasien/riwayat', [PasienController::class, 'indexPeriksa'])->name('pasien.riwayat');

        Route::get('/pasien/daftar', [PasienController::class, 'indexDaftar'])->name('pasien.daftar');
        Route::get('/pasien/daftar/show-poli', [PasienController::class, 'showPoli'])->name('pasien.poliShow');
        Route::post('/pasien/daftar', [PasienController::class, 'storeDaftar'])->name('pasien.daftarStore');

        // Route::get('/pasien/riwayat', [PasienController::class, 'showPeriksas'])->name('pasien.riwayat');
        // Route::get('/pasien/periksa', [PasienController::class, 'createPeriksa'])->name('pasien.periksa');
        // Route::post('/pasien/periksa', [PasienController::class, 'storePeriksa'])->name('pasien.periksa.store');

    });

    //AdminRoutes
    Route::middleware('role:admin')->group(function(){
        Route::get('/admin',[AdminController::class, 'dashboardAdmin'])->name('admin.dashboard');

        Route::get('/admin/dokter',[AdminController::class, 'indexDokter'])->name('admin.dokter');
        Route::post('/admin/dokter',[AdminController::class, 'storeDokter'])->name('admin.dokterStore');
        Route::get('/admin/dokter/edit/{id}',[AdminController::class, 'editDokter'])->name('admin.dokterEdit');
        Route::put('/admin/dokter/update/{id}',[AdminController::class, 'updateDokter'])->name('admin.dokterUpdate');
        Route::delete('/admin/dokter/delete/{id}',[AdminController::class, 'destroyDokter'])->name('admin.dokterDelete');

        Route::get('/admin/pasien',[AdminController::class, 'indexPasien'])->name('admin.pasien');
        Route::post('/admin/pasien',[AdminController::class, 'storePasien'])->name('admin.pasienStore');
        Route::get('/admin/pasien/edit/{id}',[AdminController::class, 'editPasien'])->name('admin.pasienEdit');
        Route::put('/admin/pasien/update/{id}',[AdminController::class, 'updatePasien'])->name('admin.pasienUpdate');
        Route::delete('/admin/pasien/delete/{id}',[AdminController::class, 'destroyPasien'])->name('admin.pasienDelete');
        
        Route::get('/admin/poli',[AdminController::class, 'indexPoli'])->name('admin.poli');
        Route::post('/admin/poli',[AdminController::class, 'storePoli'])->name('admin.poliStore');
        Route::get('/admin/poli/edit/{id}',[AdminController::class, 'editPoli'])->name('admin.poliEdit');
        Route::put('/admin/poli/update/{id}',[AdminController::class, 'updatePoli'])->name('admin.poliUpdate');
        Route::delete('/admin/poli/delete/{id}',[AdminController::class, 'destroyPoli'])->name('admin.poliDelete');

        Route::get('/admin/obat', [AdminController::class, 'indexObat'])->name('admin.obat');
        Route::post('/admin/obat', [AdminController::class, 'storeObat'])->name('admin.obatStore');
        Route::get('/admin/obat/edit/{id}', [AdminController::class, 'editObat'])->name('admin.obatEdit');
        Route::put('/admin/obat/update/{id}', [AdminController::class, 'updateObat'])->name('admin.obatUpdate');
        Route::delete('/admin/obat/delete/{id}', [AdminController::class, 'destroyObat'])->name('admin.obatDelete');
    });

});

// Route::get('/admin',[AdminController::class, 'dashboardAdmin'])->name('admin.dashboard');