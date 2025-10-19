<?php

namespace App\Http\Controllers;

use App\Models\DayCoffe;

class HomeController extends Controller
{
    // Halaman Home
    public function index()
    {
        $day_coffe = DayCoffe::take(4)->get();
        return view('home', compact('day_coffe'));
    }

    // Halaman Profil
    public function profil()
    {
        // Kalau nanti ada data user yang mau ditampilkan, bisa ditambahkan
        return view('auth.profil'); // sesuaikan path blade profil kamu
    }
}

