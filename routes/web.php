<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// ---- Halaman publik (warga) ----
Route::redirect('/', '/lapor');
Route::get('/lapor', [LaporanController::class, 'create'])->name('laporan.create');
Route::post('/lapor', [LaporanController::class, 'store'])->name('laporan.store');

// ---- Login petugas ----
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ---- Pengelolaan laporan (petugas) ----
Route::middleware('auth')->group(function () {
    Route::resource('laporan', LaporanController::class)
        ->except(['create', 'store']);
});
