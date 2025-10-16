<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;





// Landing page / semua user bisa lihat
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/legalitas', function () {
    return view('legalitas');
})->name('legalitas');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

//////////////////////////////////////////

// Profil hanya untuk user login
Route::get('/profil', function () {
    return view('profil');
})->middleware('auth')->name('profil');

// Halaman login & register
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


// Halaman Beli / checkout harus login
Route::get('/beli/{id}', function ($id) {
    // logika beli, misal ambil menu by id
    return view('beli', ['id' => $id]);
})->middleware('auth')->name('beli');
