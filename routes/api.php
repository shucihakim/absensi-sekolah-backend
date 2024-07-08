<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/about', [DashboardController::class, 'about']);

/*
    Available middlewares:  
    - auth.all (All Access)
    - auth.admin
    - auth.g
    - auth.murid
    - auth.ortu
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/settings/version', [SettingsController::class, 'get_version']);
});

Route::middleware(['auth.all'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/murid', [DashboardController::class, 'murid']);
    
    Route::get('/settings/sekolah/detail', [SettingsController::class, 'detail_sekolah']);
    Route::post('/settings/sekolah/update', [SettingsController::class, 'update_sekolah']);
    Route::post('/settings/lokasi/update', [SettingsController::class, 'update_lokasi']);
    
    Route::get('/pengguna/list', [PenggunaController::class, 'list']);
    Route::post('/pengguna/create', [PenggunaController::class, 'create']);
    Route::post('/pengguna/update', [PenggunaController::class, 'update']);
    Route::post('/pengguna/picture/upload', [PenggunaController::class, 'upload_picture']);
    Route::post('/pengguna/picture/delete', [PenggunaController::class, 'delete_picture']);
    
    Route::get('/admin/list', [AdminController::class, 'list']);
    Route::get('/admin/get/{id}', [AdminController::class, 'get']);
    Route::post('/admin/create', [AdminController::class, 'create']);
    Route::post('/admin/update/{id}', [AdminController::class, 'update']);
    Route::post('/admin/inactive/{id}', [AdminController::class, 'inactive']);
    Route::post('/admin/delete/{id}', [AdminController::class, 'delete']);
   
    Route::get('/guru/list', [GuruController::class, 'list']);
    Route::get('/guru/get/{id}', [GuruController::class, 'get']);
    Route::post('/guru/create', [GuruController::class, 'create']);
    Route::post('/guru/update/{id}', [GuruController::class, 'update']);
    Route::post('/guru/inactive/{id}', [GuruController::class, 'inactive']);
    Route::post('/guru/delete/{id}', [GuruController::class, 'delete']);
    
    Route::get('/murid/list', [MuridController::class, 'list']);
    Route::get('/murid/get/{id}', [MuridController::class, 'get']);
    Route::get('/murid/kelas/{id}', [MuridController::class, 'getByKelas']);
    Route::post('/murid/create', [MuridController::class, 'create']);
    Route::post('/murid/update/{id}', [MuridController::class, 'update']);
    Route::post('/murid/inactive/{id}', [MuridController::class, 'inactive']);
    Route::post('/murid/delete/{id}', [MuridController::class, 'delete']);

    Route::get('/ortu/list', [OrtuController::class, 'list']);
    Route::get('/ortu/get/{id}', [OrtuController::class, 'get']);
    Route::post('/ortu/create', [OrtuController::class, 'create']);
    Route::post('/ortu/update/{id}', [OrtuController::class, 'update']);
    Route::post('/ortu/inactive/{id}', [OrtuController::class, 'inactive']);
    Route::post('/ortu/delete/{id}', [OrtuController::class, 'delete']);
    
    Route::get('/semester/list', [SemesterController::class, 'list']);
    Route::get('/semester/get/{id}', [SemesterController::class, 'get']);
    Route::post('/semester/create', [SemesterController::class, 'create']);
    Route::post('/semester/update/{id}', [SemesterController::class, 'update']);
    Route::post('/semester/inactive/{id}', [SemesterController::class, 'inactive']);
    Route::post('/semester/delete/{id}', [SemesterController::class, 'delete']);

    Route::get('/kelas/list', [KelasController::class, 'list']);
    Route::get('/kelas/total/{id}', [KelasController::class, 'total']);
    Route::get('/kelas/get/{id}', [KelasController::class, 'get']);
    Route::post('/kelas/murid/add', [KelasController::class, 'addMurid']);
    Route::post('/kelas/murid/delete', [KelasController::class, 'removeMurid']);
    Route::post('/kelas/create', [KelasController::class, 'create']);
    Route::post('/kelas/update/{id}', [KelasController::class, 'update']);
    Route::post('/kelas/inactive/{id}', [KelasController::class, 'inactive']);
    Route::post('/kelas/delete/{id}', [KelasController::class, 'delete']);
    
    Route::get('/mapel/list', [MapelController::class, 'list']);
    Route::get('/mapel/get/{id}', [MapelController::class, 'get']);
    Route::post('/mapel/create', [MapelController::class, 'create']);
    Route::post('/mapel/update/{id}', [MapelController::class, 'update']);
    Route::post('/mapel/inactive/{id}', [MapelController::class, 'inactive']);
    Route::post('/mapel/delete/{id}', [MapelController::class, 'delete']);

    Route::get('/jurnal/list', [JurnalController::class, 'list']);
    Route::get('/jurnal/list/guru/{id}', [JurnalController::class, 'list_by_guru']);
    Route::get('/jurnal/get/{id}', [JurnalController::class, 'get']);
    Route::get('/jurnal/report', [JurnalController::class, 'downloadReport']);
    Route::post('/jurnal/create', [JurnalController::class, 'create']);
    Route::post('/jurnal/update/{id}', [JurnalController::class, 'update']);
    Route::post('/jurnal/inactive/{id}', [JurnalController::class, 'inactive']);
    Route::post('/jurnal/delete/{id}', [JurnalController::class, 'delete']);
    
    Route::get('/absensi/list', [AbsensiController::class, 'list']);
    Route::get('/absensi/list/kelas/{id}', [AbsensiController::class, 'list_by_kelas']);
    Route::get('/absensi/list/murid/{id}', [AbsensiController::class, 'list_by_murid']);
    Route::get('/absensi/list/jurnal/{id}', [AbsensiController::class, 'list_by_jurnal']);
    Route::get('/absensi/get/{id}', [AbsensiController::class, 'get']);
    Route::post('/absensi/create', [AbsensiController::class, 'create']);
    Route::post('/absensi/update', [AbsensiController::class, 'update']);
    Route::post('/absensi/update/kelas', [AbsensiController::class, 'update_by_kelas']);
    Route::post('/absensi/inactive/{id}', [AbsensiController::class, 'inactive']);
    Route::post('/absensi/delete/{id}', [AbsensiController::class, 'delete']);
});