<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/profil');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Tampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

  
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
        'phone' => 'nullable|string|max:20',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'profile_picture' => null,
    ]);

    // Jangan login otomatis, langsung arahkan ke login
    return redirect()->route('login')->with('success', 'Akun berhasil dibuat, silakan login.');
}


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // ===============================
    // Login dengan Google
    // ===============================

    // Redirect ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback Google
    public function handleGoogleCallback()
    {
        // Tambahkan PHPDoc supaya Intelephense tahu tipe objek
        /** @var \Laravel\Socialite\Two\GoogleProvider $googleDriver */
        $googleDriver = Socialite::driver('google');

        // Panggil stateless() seperti biasa
        $googleUser = $googleDriver->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'password' => Hash::make(rand(1000, 9999)), // password random
                'profile_picture' => $googleUser->avatar ?? null,
            ]
        );

        Auth::login($user);
        return redirect('/profil');
    }
}
