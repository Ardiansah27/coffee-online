<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GoogleController;

//////////////////////////////////////////
// Landing page / semua user bisa lihat
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/legalitas', function () { return view('legalitas'); })->name('legalitas');
Route::get('/contact', function () { return view('contact'); })->name('contact');

//////////////////////////////////////////
// Halaman user login / profil
Route::middleware('auth')->group(function() {
    Route::get('/profil', function() { return view('profil'); })->name('profil');

    // Halaman beli / checkout
    Route::get('/beli/{id}', function ($id) { return view('beli', ['id' => $id]); })
        ->name('beli');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

//////////////////////////////////////////
// Halaman login & register
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

//////////////////////////////////////////
// Google Login
Route::get('/login/google', [GoogleController::class,'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [GoogleController::class,'handleGoogleCallback']);

//////////////////////////////////////////
// Fitur Lupa Password / Reset Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])
    ->name('forgot.password');

Route::post('/send-otp', [ForgotPasswordController::class, 'sendOtp'])
    ->name('send.otp');

Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])
    ->name('reset.password.form');

Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('reset.password');
    
