<?php

use App\Http\Controllers\GajiController;
use App\Http\Controllers\Master\KasbonController;
use App\Http\Controllers\Master\LemburController;
use App\Http\Controllers\Master\TunjanganSkillController;
use App\Http\Controllers\Master\JabatanController;
use App\Http\Controllers\Master\PegawaiController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\Master\KehadiranController;
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
Route::get('/download',  [App\Http\Controllers\HomeController::class, 'download'])->name('download');
Route::get('download/{start_date}/{end_date}', [App\Http\Controllers\HomeController::class, 'download']);

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

Route::prefix('data')->group(function () {
    Route::get('/gaji', [App\Http\Controllers\Data\GajiController::class, 'index'])->name('gaji');
    Route::get('/json-gaji', [App\Http\Controllers\Data\GajiController::class, 'json'])->name('json-data');
    Route::get('/gaji-detail/{no_slip_gaji}', [App\Http\Controllers\Data\GajiController::class, 'detail'])->name('detail');
    Route::get('/gaji-cetak-pdf/{no_slip_gaji}', [App\Http\Controllers\Data\GajiController::class, 'cetak_pdf'])->name('cetak_pdf');
    Route::get('/gaji-cetak-all-pdf', [App\Http\Controllers\Data\GajiController::class, 'cetak_all'])->name('cetak_all');
});

Route::prefix('master')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/json-user', [UserController::class, 'json'])->name('json-data');
    Route::get('/user/form', [UserController::class, 'create'])->name('create');
    Route::post('/user-store', [UserController::class, 'store'])->name('store');
    Route::get('/user/{id}', [UserController::class, 'edit'])->name('edit');
    Route::post('/user-update/{id}', [UserController::class, 'update'])->name('update');
    Route::get('/user-delete/{id}', [UserController::class, 'delete'])->name('delete');
    Route::get('/user-cetak-all-pdf', [UserController::class, 'cetak_all'])->name('user-cetak-all-pdf');

    Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan');
    Route::get('/json-jabatan', [JabatanController::class, 'json'])->name('json-data');
    Route::get('/jabatan/form', [JabatanController::class, 'create'])->name('create');
    Route::post('/jabatan-store', [JabatanController::class, 'store'])->name('store');
    Route::get('/jabatan/{kd_jabatan}', [JabatanController::class, 'edit'])->name('edit');
    Route::post('/jabatan-update/{kd_jabatan}', [JabatanController::class, 'update'])->name('update');
    Route::get('/jabatan-delete/{kd_jabatan}', [JabatanController::class, 'delete'])->name('delete');
    Route::get('/jabatan-cetak-all-pdf', [JabatanController::class, 'cetak_all'])->name('jabatan-cetak-all-pdf');
    Route::get('/json-jabatan/{kd_jabatan}', [JabatanController::class, 'json_get_by_kd_jabatan'])->name('json-kd-jabatan');

    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai');
    Route::get('/json-pegawai', [PegawaiController::class, 'json'])->name('json-data');
    Route::get('/pegawai/form', [PegawaiController::class, 'create'])->name('create');
    Route::post('/pegawai-store', [PegawaiController::class, 'store'])->name('store');
    Route::get('/pegawai/{nip}', [PegawaiController::class, 'edit'])->name('edit');
    Route::post('/pegawai-update/{nip}', [PegawaiController::class, 'update'])->name('update');
    Route::get('/pegawai-delete/{nip}', [PegawaiController::class, 'delete'])->name('delete');
    Route::get('/pegawai-cetak-all-pdf', [PegawaiController::class, 'cetak_all'])->name('pegawai-cetak-all-pdf');
    Route::get('/json-status', [PegawaiController::class, 'json_get_by_status'])->name('json-status');
    Route::get('/json-pegawai/{nama}', [PegawaiController::class, 'json_get_by_nama'])->name('json-nama');

    Route::get('/kasbon', [KasbonController::class, 'index'])->name('kasbon');
    Route::get('/json-kasbon', [KasbonController::class, 'json'])->name('json-data');
    Route::get('/kasbon/form', [KasbonController::class, 'create'])->name('create');
    Route::post('/kasbon-store', [KasbonController::class, 'store'])->name('store');
    Route::get('/kasbon/{kd_kasbon}', [KasbonController::class, 'edit'])->name('edit');
    Route::post('/kasbon-update/{kd_kasbon}', [KasbonController::class, 'update'])->name('update');
    Route::get('/kasbon-delete/{kd_kasbon}', [KasbonController::class, 'delete'])->name('delete');
    Route::get('/kasbon-cetak-all-pdf', [KasbonController::class, 'cetak_all'])->name('kasbon-cetak-all-pdf');

    Route::get('/kehadiran', [KehadiranController::class, 'index'])->name('kehadiran');
    Route::get('/json-kehadiran', [KehadiranController::class, 'json'])->name('json-data');
    Route::get('/kehadiran/form', [KehadiranController::class, 'create'])->name('create');
    Route::post('/kehadiran-store', [KehadiranController::class, 'store'])->name('store');
    Route::get('/kehadiran/{kd_kehadiran}', [KehadiranController::class, 'edit'])->name('edit');
    Route::post('/kehadiran-update/{kd_kehadiran}', [KehadiranController::class, 'update'])->name('update');
    Route::get('/kehadiran-delete/{kd_kehadiran}', [KehadiranController::class, 'delete'])->name('delete');
    Route::get('/kehadiran-cetak-all-pdf', [KehadiranController::class, 'cetak_all'])->name('kehadiran-cetak-all-pdf');

    Route::get('/lembur', [LemburController::class, 'index'])->name('lembur');
    Route::get('/json-lembur', [LemburController::class, 'json'])->name('json-data');
    Route::get('/lembur/form', [LemburController::class, 'create'])->name('create');
    Route::post('/lembur-store', [LemburController::class, 'store'])->name('store');
    Route::get('/lembur/{kd_lembur}', [LemburController::class, 'edit'])->name('edit');
    Route::post('/lembur-update/{kd_lembur}', [LemburController::class, 'update'])->name('update');
    Route::get('/lembur-delete/{kd_lembur}', [LemburController::class, 'delete'])->name('delete');
    Route::get('/lembur-cetak-all-pdf', [LemburController::class, 'cetak_all'])->name('lembur-cetak-all-pdf');

    Route::get('/tunjangan-skill', [TunjanganSkillController::class, 'index'])->name('tunjangan-skill');
    Route::get('/json-tunjangan-skill', [TunjanganSkillController::class, 'json'])->name('json-data');
    Route::get('/tunjangan-skill/form', [TunjanganSkillController::class, 'create'])->name('create');
    Route::post('/tunjangan-skill-store', [TunjanganSkillController::class, 'store'])->name('store');
    Route::get('/tunjangan-skill/{kd_tunjangan_skill}', [TunjanganSkillController::class, 'edit'])->name('edit');
    Route::post('/tunjangan-skill-update/{kd_tunjangan_skill}', [TunjanganSkillController::class, 'update'])->name('update');
    Route::get('/tunjangan-skill-delete/{kd_tunjangan_skill}', [TunjanganSkillController::class, 'delete'])->name('delete');
    Route::get('/tunjangan-skill-cetak-all-pdf', [TunjanganSkillController::class, 'cetak_all'])->name('tunjangan-skill-cetak-all-pdf');
});

