<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use File; // Tambahkan ini di atas

class AdminController extends Controller
{
  public function index()
{
    // Mengambil statistik
    $totalMenu = Menu::count();
    $totalCategory = Menu::distinct('category')->count('category');
    $totalAdmin = \App\Models\User::where('role', 'admin')->count();

    // Mengambil 5 menu terbaru untuk ditampilkan di tabel dashboard
    $recentMenus = Menu::latest()->take(5)->get();

    return view('admin.dashboard', compact('totalMenu', 'totalCategory', 'totalAdmin', 'recentMenus'));
}
    public function menu()
    {
        $menus = Menu::orderBy('created_at', 'desc')->get();
        return view('admin.menu', compact('menus'));
    }

    public function addMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Espresso Based,Manual Brew,Signature,Non-Coffee',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/menu'), $imageName);
        }

        Menu::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return back()->with('success', 'Menu berhasil ditambahkan');
    }

    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Espresso Based,Manual Brew,Signature,Non-Coffee',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = $menu->image;
        if ($request->hasFile('image')) {
            // ✅ Hapus gambar lama dari folder jika ada
            if ($menu->image && file_exists(public_path('images/menu/' . $menu->image))) {
                unlink(public_path('images/menu/' . $menu->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/menu'), $imageName);
        }

        $menu->update([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return back()->with('success', 'Menu berhasil diupdate');
    }

    public function deleteMenu($id)
    {
        $menu = Menu::findOrFail($id);

        // ✅ Hapus file gambar dari folder sebelum data di DB dihapus
        if ($menu->image && file_exists(public_path('images/menu/' . $menu->image))) {
            unlink(public_path('images/menu/' . $menu->image));
        }

        $menu->delete();
        return back()->with('success', 'Menu berhasil dihapus');
    }
}