<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DataSantriController;
use App\Http\Controllers\Backend\JadwalController;
use App\Http\Controllers\Backend\PostsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard2', [DashboardController::class, 'index2'])->name('dashboard2');
    Route::get('/dashboard/data-santri', [DashboardController::class, 'getDataSantri'])->name('dashboard.data-santri');
    Route::get('/dashboard/posts', [DashboardController::class, 'getDataPosts'])->name('dashboard.posts');
    // Data Santri
    Route::get('/data-santri', [DataSantriController::class, 'index'])->name('data-santri');
    Route::get('/data-santri/data', [DataSantriController::class, 'getData'])->name('data-santri.data');
    Route::get('/data-santri/tambah', [DataSantriController::class, 'tambah'])->name('data-santri.tambah');
    Route::post('/data-santri/store', [DataSantriController::class, 'store'])->name('data-santri.store');
    Route::get('/data-santri/edit', [DataSantriController::class, 'edit'])->name('data-santri.edit');
    Route::patch('/data-santri/update', [DataSantriController::class, 'update'])->name('data-santri.update');
    Route::delete('/data-santri/destroy', [DataSantriController::class, 'destroy'])->name('data-santri.destroy');
    // Jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
    // Posts
    Route::get('/posts', [PostsController::class, 'index'])->name('posts');
    Route::get('/posts/data', [PostsController::class, 'getData'])->name('posts.data');
    Route::get('/posts/tambah', [PostsController::class, 'tambah'])->name('posts.tambah');
    Route::post('/posts/store', [PostsController::class, 'store'])->name('posts.store');
    Route::get('/posts/edit', [PostsController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/update', [PostsController::class, 'update'])->name('posts.update');
    Route::delete('/posts/destroy', [PostsController::class, 'destroy'])->name('posts.destroy');
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