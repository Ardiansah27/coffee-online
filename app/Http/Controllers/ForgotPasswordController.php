<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // Tampilkan form forgot password
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    // Tampilkan form reset password
    public function showResetForm()
    {
        return view('auth.reset-password');
    }

    // Kirim OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'identifier' => 'required'
        ]);

        $identifier = $request->identifier;

        $user = User::where('email', $identifier)
                    ->orWhere('phone', $identifier)
                    ->first();

        if (!$user) {
            return back()->withErrors(['identifier' => 'Akun tidak ditemukan']);
        }

        $otp = rand(100000, 999999);
        session([
            'otp' => $otp,
            'identifier' => $identifier,
            'otp_expiry' => now()->addMinutes(5),
        ]);

        // Kirim OTP via email (PHPMailer atau Laravel Mail)
        Mail::raw("Kode OTP Anda: $otp (berlaku 5 menit)", function($message) use ($user){
            $message->to($user->email)
                    ->subject('Kode OTP Lupa Password');
        });

        return redirect()->route('reset.password.form')
                         ->with('success', 'OTP telah dikirim ke email atau nomor HP Anda');
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if (session('otp') != $request->otp || now() > session('otp_expiry')) {
            return back()->withErrors(['otp' => 'OTP salah atau sudah kadaluarsa']);
        }

        $user = User::where('email', session('identifier'))
                    ->orWhere('phone', session('identifier'))
                    ->first();

        if(!$user) {
            return back()->withErrors(['identifier'=>'Akun tidak ditemukan']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget(['otp','identifier','otp_expiry']);

        return redirect()->route('login')->with('success','Password berhasil diubah');
    }
}
