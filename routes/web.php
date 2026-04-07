<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\UmpanBalikController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

Route::middleware('auth')->group(function () {
    Route::get('/', [AspirasiController::class, 'index'])->name('home');
    Route::get('/home', [AspirasiController::class, 'index'])->name('home');
    Route::resource('siswa', SiswaController::class);
    Route::resource('aspirasi', AspirasiController::class);
    Route::resource('umpan-balik', UmpanBalikController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('users', UserController::class);
});