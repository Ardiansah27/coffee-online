<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        // Tambahkan PHPDoc supaya Intelephense mengenal tipe objek
        /** @var \Laravel\Socialite\Two\GoogleProvider $googleDriver */
        $googleDriver = Socialite::driver('google');

        // Panggil stateless() seperti biasa
        $googleUser = $googleDriver->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'google_id' => $googleUser->id,
                'password' => bcrypt(rand(1000, 9999)),
                'profile_picture' => $googleUser->avatar ?? null,
            ]
        );

        Auth::login($user);

        return redirect()->route('home');
    }
}
