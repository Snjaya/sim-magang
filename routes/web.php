<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\PembimbingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute ini hanya bisa diakses oleh user dengan role 'admin'
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('pembimbing', PembimbingController::class);
    Route::resource('peserta', PesertaController::class);
});

// Rute ini hanya bisa diakses oleh user dengan role 'pembimbing'
Route::middleware(['auth', 'role:pembimbing'])->group(function () {
    Route::get('/pembimbing/dashboard', function () {
        return '<h1>Selamat Datang, Pembimbing!</h1>';
    });
});

require __DIR__ . '/auth.php';
