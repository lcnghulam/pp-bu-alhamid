<?php

use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

require __DIR__.'/auth.php';
// require __DIR__.'/backend.php';