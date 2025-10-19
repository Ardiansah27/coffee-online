<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\LandingController;


//////////////////////////////////////////
// 🔹 Landing page / semua user bisa lihat


Route::get('/', [LandingController::class, 'index'])->name('landing');

// Halaman lain tetap bisa diakses guest
Route::get('/menu-guest', [MenuController::class, 'index'])
    ->name('menu-guest'); // Nama route unik untuk guest

Route::get('/legalitas', function () {
    return view('legalitas');
})->name('legalitas');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');



//////////////////////////////////////////
// 🔹 Halaman user login / home
Route::middleware('auth')->group(function () {

    // Halaman utama user (home.blade.php)
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/menu', [MenuController::class, 'index'])->name('menu-login');
    Route::get('/legalitas', function () {
        return view('legalitas');
    })->name('legalitas');
    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');

    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::post('/profil/alamat', [ProfilController::class, 'storeAlamat'])->name('profil.alamat.store');
    Route::delete('/profil/alamat/{id}', [ProfilController::class, 'deleteAlamat'])->name('profil.alamat.delete');


    // Halaman beli / checkout
    Route::get('/beli/{id}', function ($id) {
        return view('beli', ['id' => $id]);
    })->name('beli');


    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

//////////////////////////////////////////
// 🔹 Login & Register
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

//////////////////////////////////////////
// 🔹 Google Login
Route::get('/login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

//////////////////////////////////////////
// 🔹 Fitur Lupa Password / Reset Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('forgot.password');
Route::post('/send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('send.otp');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('reset.password.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset.password');
