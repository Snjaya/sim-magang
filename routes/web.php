<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\PembimbingController;
use App\Http\Controllers\Pembimbing\TugasController;
use App\Http\Controllers\Peserta\TugasController as PesertaTugasController;

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
    Route::resource('peserta', PesertaController::class)->parameter('peserta', 'peserta');
});

// Rute ini hanya bisa diakses oleh user dengan role 'pembimbing'
Route::middleware(['auth', 'role:pembimbing'])->prefix('pembimbing')->group(function () {
    Route::resource('tugas', TugasController::class)->names('pembimbing.tugas');
});

// Rute ini hanya bisa diakses oleh user dengan role 'peserta'
Route::middleware(['auth', 'role:peserta'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('tugas', [PesertaTugasController::class, 'index'])->name('tugas.index');

    // PARAMETER DIUBAH DI SINI
    Route::get('tugas/{tugas}', [PesertaTugasController::class, 'show'])->name('tugas.show');

    // PARAMETER DIUBAH DI SINI JUGA
    Route::patch('tugas/{tugas}/submit', [PesertaTugasController::class, 'submit'])->name('tugas.submit');
});

require __DIR__ . '/auth.php';
