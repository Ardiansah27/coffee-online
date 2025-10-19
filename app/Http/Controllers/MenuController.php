<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        // Ambil semua data menu dari database
        $menu_coffe = Menu::all();

        // Kirim ke view menu.blade.php
        return view('menu', compact('menu_coffe'));
    }
}
