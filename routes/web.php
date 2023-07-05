<?php

use App\Http\Controllers\DetailGajiController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\Master\KasbonController;
use App\Http\Controllers\Master\LemburController;
use App\Http\Controllers\Master\TunjanganSkillController;
use App\Http\Controllers\Master\JabatanController;
use App\Http\Controllers\Master\KaryawanController;
use App\Http\Controllers\Master\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['reset'=>false,'register'=>false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('/profil', [App\Http\Controllers\HomeController::class, 'profil'])->name('profil');
Route::post('/profil-update/{id}', [UserController::class, 'updateProfile'])->name('updateProfile');
Route::post('/password-update/{id}', [UserController::class, 'updatePassword'])->name('updatePassword');
Route::get('/bar-chart',  [App\Http\Controllers\HomeController::class, 'cart'])->name('cart');

Route::get('/gaji', [GajiController::class, 'index'])->name('gaji');
Route::get('/json-gaji', [GajiController::class, 'json'])->name('json-data');
Route::get('/gaji/form', [GajiController::class, 'create'])->name('create');
Route::post('/gaji-store', [GajiController::class, 'store'])->name('store');
Route::get('/gaji/{no_slip_gaji}', [GajiController::class, 'edit'])->name('edit');
Route::post('/gaji-update/{no_slip_gaji}', [GajiController::class, 'update'])->name('update');
Route::get('/gaji-delete/{no_slip_gaji}', [GajiController::class, 'delete'])->name('delete');
Route::get('/gaji-detail/{no_slip_gaji}', [GajiController::class, 'detail'])->name('detail');
Route::get('/gaji-cetak-pdf/{no_slip_gaji}', [GajiController::class, 'cetak_pdf'])->name('cetak_pdf');
Route::get('/gaji-cetak-all-pdf', [GajiController::class, 'cetak_all'])->name('cetak_all');

Route::prefix('master')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/json-user', [UserController::class, 'json'])->name('json-data');
    Route::get('/user/form', [UserController::class, 'create'])->name('create');
    Route::post('/user-store', [UserController::class, 'store'])->name('store');
    Route::get('/user/{id}', [UserController::class, 'edit'])->name('edit');
    Route::post('/user-update/{id}', [UserController::class, 'update'])->name('update');
    Route::get('/user-delete/{id}', [UserController::class, 'delete'])->name('delete');

    Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan');
    Route::get('/json-jabatan', [JabatanController::class, 'json'])->name('json-data');
    Route::get('/jabatan/form', [JabatanController::class, 'create'])->name('create');
    Route::post('/jabatan-store', [JabatanController::class, 'store'])->name('store');
    Route::get('/jabatan/{kd_jabatan}', [JabatanController::class, 'edit'])->name('edit');
    Route::post('/jabatan-update/{kd_jabatan}', [JabatanController::class, 'update'])->name('update');
    Route::get('/jabatan-delete/{kd_jabatan}', [JabatanController::class, 'delete'])->name('delete');

    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan');
    Route::get('/json-karyawan', [KaryawanController::class, 'json'])->name('json-data');
    Route::get('/karyawan/form', [KaryawanController::class, 'create'])->name('create');
    Route::post('/karyawan-store', [KaryawanController::class, 'store'])->name('store');
    Route::get('/karyawan/{nip}', [KaryawanController::class, 'edit'])->name('edit');
    Route::post('/karyawan-update/{nip}', [KaryawanController::class, 'update'])->name('update');
    Route::get('/karyawan-delete/{nip}', [KaryawanController::class, 'delete'])->name('delete');

    Route::get('/kasbon', [KasbonController::class, 'index'])->name('kasbon');
    Route::get('/json-kasbon', [KasbonController::class, 'json'])->name('json-data');
    Route::get('/kasbon/form', [KasbonController::class, 'create'])->name('create');
    Route::post('/kasbon-store', [KasbonController::class, 'store'])->name('store');
    Route::get('/kasbon/{kd_kasbon}', [KasbonController::class, 'edit'])->name('edit');
    Route::post('/kasbon-update/{kd_kasbon}', [KasbonController::class, 'update'])->name('update');
    Route::get('/kasbon-delete/{kd_kasbon}', [KasbonController::class, 'delete'])->name('delete');

    Route::get('/lembur', [LemburController::class, 'index'])->name('lembur');
    Route::get('/json-lembur', [LemburController::class, 'json'])->name('json-data');
    Route::get('/lembur/form', [LemburController::class, 'create'])->name('create');
    Route::post('/lembur-store', [LemburController::class, 'store'])->name('store');
    Route::get('/lembur/{kd_lembur}', [LemburController::class, 'edit'])->name('edit');
    Route::post('/lembur-update/{kd_lembur}', [LemburController::class, 'update'])->name('update');
    Route::get('/lembur-delete/{kd_lembur}', [LemburController::class, 'delete'])->name('delete');

    Route::get('/tunjangan-skill', [TunjanganSkillController::class, 'index'])->name('tunjangan-skill');
    Route::get('/json-tunjangan-skill', [TunjanganSkillController::class, 'json'])->name('json-data');
    Route::get('/tunjangan-skill/form', [TunjanganSkillController::class, 'create'])->name('create');
    Route::post('/tunjangan-skill-store', [TunjanganSkillController::class, 'store'])->name('store');
    Route::get('/tunjangan-skill/{kd_tunjangan_skill}', [TunjanganSkillController::class, 'edit'])->name('edit');
    Route::post('/tunjangan-skill-update/{kd_tunjangan_skill}', [TunjanganSkillController::class, 'update'])->name('update');
    Route::get('/tunjangan-skill-delete/{kd_tunjangan_skill}', [TunjanganSkillController::class, 'delete'])->name('delete');
});

