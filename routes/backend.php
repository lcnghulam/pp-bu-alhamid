<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DataSantriController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //Data Santri
    Route::get('/data-santri', [DataSantriController::class, 'index'])->name('data-santri');
    Route::get('/data-santri/data', [DataSantriController::class, 'getData'])->name('data-santri.data');
    Route::get('/data-santri/tambah', [DataSantriController::class, 'tambah'])->name('data-santri.tambah');
    Route::post('/data-santri/store', [DataSantriController::class, 'store'])->name('data-santri.store');
    // Route::match(['get', 'post'], '/data-santri/edit', [DataSantriController::class, 'edit'])->name('data-santri.edit');
    Route::get('/data-santri/edit', [DataSantriController::class, 'edit'])->name('data-santri.edit');
    Route::patch('/data-santri/update', [DataSantriController::class, 'update'])->name('data-santri.update');
    Route::delete('/data-santri/destroy', [DataSantriController::class, 'destroy'])->name('data-santri.destroy');
});


// dd('Backend route loaded!');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';