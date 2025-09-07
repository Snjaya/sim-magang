<?php

use App\Http\Controllers\Admin\PembimbingController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Pembimbing\TaskController;
use App\Http\Controllers\Peserta\TaskController as PesertaTaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('pembimbing', PembimbingController::class);
    Route::resource('peserta', PesertaController::class)
        ->parameter('peserta', 'peserta');
    Route::get('peserta/{peserta}/cetak-kartu', [PesertaController::class, 'cetakKartu'])->name('peserta.cetakKartu');
});

Route::middleware(['auth', 'role:pembimbing'])->prefix('pembimbing')->group(function () {
    Route::resource('task', TaskController::class)
        ->parameter('task', 'task')
        ->names('pembimbing.task');
    Route::patch('task/{task}/verify', [TaskController::class, 'verify'])->name('pembimbing.task.verify');
});

Route::middleware(['auth', 'role:peserta'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('task', [PesertaTaskController::class, 'index'])->name('task.index');
    Route::get('task/{task}', [PesertaTaskController::class, 'show'])->name('task.show');
    Route::patch('task/{task}/submit', [PesertaTaskController::class, 'submit'])->name('task.submit');
});

require __DIR__ . '/auth.php';
