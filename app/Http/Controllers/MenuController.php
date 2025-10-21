<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Halaman menu untuk semua user (guest + login)
    public function showMenu()
    {
        $menu_coffee = Menu::all(); // Ambil semua menu
        $categories = Menu::select('category')->distinct()->pluck('category'); // Ambil kategori unik

        // Gunakan satu view untuk semua user
        return view('menu', compact('menu_coffee', 'categories'));
    }
}
