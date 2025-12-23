<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AdminController; // 🔸 TAMBAHAN ROLE ADMIN
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\RestoController;
//////////////////////////////////////////
// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Menu untuk semua user (guest + login)
Route::get('/menu', [MenuController::class, 'showMenu'])->name('menu');

// Halaman legalitas & contact (semua user)
Route::view('/legalitas', 'legalitas')->name('legalitas');
Route::view('/contact', 'contact')->name('contact');


//////////////////////////////////////////
// Halaman user login (auth middleware)
Route::middleware('auth')->group(function () {
    
    // Home & Logout
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Keranjang Belanja (Troli)
    Route::get('/cart', [CartController::class, 'index'])->name('troli');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('troli.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('troli.remove');
    Route::patch('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('troli.update');

  // Profil & Manajemen Alamat (ProfilController)
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::post('/profil/update', [ProfilController::class, 'updateProfil'])->name('profil.update');

// 1. Halaman Form Tambah Alamat (Pindah Halaman)
Route::get('/profil/alamat/tambah', [ProfilController::class, 'createAlamat'])->name('profil.alamat.create');

// 2. Proses Simpan ke Database
Route::post('/profil/alamat/store', [ProfilController::class, 'storeAlamat'])->name('profil.alamat.store');

// 3. Hapus Alamat
Route::delete('/profil/alamat/{id}', [ProfilController::class, 'deleteAlamat'])->name('profil.alamat.delete');

// 4. Set Alamat Utama
Route::post('/profil/alamat-utama/{id}', [ProfilController::class, 'setAlamatUtama'])->name('profil.alamat.utama');

// 5. Update Koordinat Map (Pinpoint)
Route::post('/profil/alamat/update-map/{id}', [ProfilController::class, 'updateMap'])->name('profil.alamat.updateMap');

    // Checkout & Transaksi
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/beli/{id}', [CartController::class, 'beliLangsung'])->name('beli');
Route::post('/checkout/process', [CartController::class, 'processCheckout'])->name('checkout.process');
       // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});
 



//////////////////////////////////////////
// 🔸 TAMBAHAN ROLE ADMIN
// Middleware 'auth' + custom middleware 'isAdmin'
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/menu', [AdminController::class, 'menu'])
        ->name('admin.menu');

    Route::post('/admin/menu/add', [AdminController::class, 'addMenu'])
        ->name('admin.menu.add');

    Route::post('/admin/menu/update/{id}', [AdminController::class, 'updateMenu'])
        ->name('admin.menu.update');

    Route::delete('/admin/menu/delete/{id}', [AdminController::class, 'deleteMenu'])
        ->name('admin.menu.delete');
});

// Route untuk tampilkan halaman dan simpan lokasi resto
Route::get('/admin/resto-setting', [App\Http\Controllers\Admin\RestoController::class, 'index'])->name('admin.resto.index');
Route::post('/admin/resto-setting', [App\Http\Controllers\Admin\RestoController::class, 'update'])->name('admin.resto.update');




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
