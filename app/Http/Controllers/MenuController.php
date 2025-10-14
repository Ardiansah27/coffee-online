<?php

namespace App\Http\Controllers;


use App\Models\Menu;

class MenuController extends Controller
{
     public function index()
    {
        // Ambil semua data dari tabel 'menus'
        $menus = Menu::all();

        // Kirim ke view resources/views/menu.blade.php
        return view('menu', compact('menus'));
    }
}
