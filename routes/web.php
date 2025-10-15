<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\HomeController;
/*

|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// Halaman Legalitas Coffee
Route::get('/legalitas', function () {
    return view('legalitas');
})->name('legalitas');

// Halaman Contact Us
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Halaman Profil (nama akun / user)
Route::get('/profil', function () {
    return view('profil');
})->name('profil');

// Halaman Login
Route::get('/login', function () {
    return view('login');
})->name('login');
