<?php


use App\Http\Controllers\AbsenPiketController;

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalPiketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

use App\Http\Controllers\PiketController;
use App\Http\Controllers\UserController;


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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/recovery', [LoginController::class, 'recovery'])->name('recovery');
Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');

Route::group(
    [
        'prefix'     => 'login'
    ],
    function () {
        Route::post('/proses', [LoginController::class, 'authenticate'])->name('login.proses');
    }
);

Route::group(
    [
        'middleware' => 'auth'
    ],
    function () {
        // dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
       
        // // menu
        Route::resource('/pengguna', UserController::class);
        Route::get('/profil', [UserController::class, 'profil'])->name('pengguna.profil');
       
        //damkar
        Route::resource('/piket', PiketController::class);
        Route::resource('/anggota', AnggotaController::class);
        Route::post('/get_grup_data', [AnggotaController::class, 'get_grup_data'])->name('anggota.get_grup_data');
        Route::get('/list_data_anggota', [AnggotaController::class, 'list_data_anggota'])->name('anggota.list_data_anggota');
        Route::resource('/jadwal_piket', JadwalPiketController::class);
        Route::post('/ketua_kelompok', [JadwalPiketController::class, 'ketua_kelompok'])->name('jadwal_piket.ketua_kelompok');
        Route::post('/simpan_data_piket', [JadwalPiketController::class, 'simpan_data_piket'])->name('jadwal_piket.simpan_data_piket');
        Route::resource('/absensi_piket', AbsenPiketController::class);
    }
);
