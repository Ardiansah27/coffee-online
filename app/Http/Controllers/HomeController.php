<?php


namespace App\Http\Controllers;

use App\Models\DayCoffe;

class HomeController extends Controller
{
    public function index()
    {
        $day_coffe = DayCoffe::take(4)->get();
        return view('home', compact('day_coffe'));
    }
}

