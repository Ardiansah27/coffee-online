<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DayCoffe; // pastikan model sudah dibuat

class LandingController extends Controller
{
    public function index()
    {
        // Jika user sudah login, redirect ke home
        if(auth()->check()) {
            return redirect()->route('home');
        }

        // Ambil semua data kopi dari database
        $day_coffe = DayCoffe::all(); 

        // Tampilkan landing-content dan kirim data
        return view('landing-page.landing-content', compact('day_coffe'));
    }
}
