<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;      // Tambahkan ini
use App\Models\OrderItem;  // Tambahkan ini
use App\Models\User;       // Tambahkan ini
use File;

class AdminController extends Controller
{
    public function index()
    {
        // Statistik Dasar
        $totalMenu = Menu::count();
        $totalCategory = Menu::distinct('category')->count('category');
        $totalAdmin = User::where('role', 'admin')->count();

        // --- FITUR BARU: STATISTIK ORDER ---
        // Hitung pesanan masuk (pending) untuk notifikasi badge
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        
        // Mengambil 5 pesanan terbaru untuk tabel dashboard
        $latestOrders = Order::with('user')->latest()->take(5)->get();

        // Mengambil 5 menu terbaru (kode lama Anda)
        $recentMenus = Menu::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalMenu', 'totalCategory', 'totalAdmin', 
            'recentMenus', 'pendingOrdersCount', 'latestOrders'
        ));
    }

    // Menampilkan halaman daftar semua pesanan
    public function orders()
    {
        $orders = Order::with(['user', 'items.menu'])->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    // Update Status Pesanan (Contoh: dari Pending ke Processing/Siapkan Kopi)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pesanan #' . $order->order_number . ' berhasil diubah menjadi ' . $request->status);
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