<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu; // Sesuaikan nama model menu kamu
use App\Models\Cart; // Pastikan kamu sudah buat model/tabel Cart
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan halaman troli
    public function index()
    {
        $cart_items = Cart::where('user_id', Auth::id())->with('menu')->get();
        return view('cart', compact('cart_items'));
    }

    // Menambah produk ke troli
 public function addToCart(Request $request, $id)
{
    $menu = Menu::findOrFail($id);
    
    // 1. Tangkap angka dari JavaScript (default 1 jika tidak terdeteksi)
    $inputQty = (int) $request->input('quantity', 1);

    // Cek apakah produk sudah ada di troli user ini
    $cartItem = Cart::where('user_id', Auth::id())
                    ->where('menu_id', $id)
                    ->first();

    if ($cartItem) {
        // 2. Tambahkan kuantitas yang baru ke kuantitas yang lama
        // Pastikan tidak melebihi stok atau batas maksimal (misal 10)
        $newQty = $cartItem->quantity + $inputQty;
        
        if ($newQty > 10) {
            $cartItem->update(['quantity' => 10]);
        } else {
            $cartItem->update(['quantity' => $newQty]);
        }
    } else {
        // 3. Masukkan produk baru dengan kuantitas yang sesuai input
        Cart::create([
            'user_id' => Auth::id(),
            'menu_id' => $id,
            'quantity' => $inputQty,
        ]);
    }

    // Hitung TOTAL JUMLAH BARANG (bukan cuma jenisnya) untuk angka merah di navbar
    $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'cartCount' => $cartCount,
            'message' => 'Kopi berhasil masuk troli!'
        ]);
    }

    return redirect()->route('troli')->with('success', 'Kopi berhasil masuk troli!');
}

   
  // Update kuantitas (+ atau -)
public function updateQuantity(Request $request, $id)
{
    // Cari item berdasarkan ID dan pastikan milik user yang sedang login
    $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->first();

    if ($cartItem) {
        // TAMBAHKAN VALIDASI: pastikan kuantitas minimal 1 dan maksimal 10
        $newQty = max(1, min(10, (int)$request->quantity));

        $cartItem->update(['quantity' => $newQty]);
        
        return response()->json([
            'success' => true,
            'message' => 'Kuantitas diupdate',
            'new_qty' => $newQty // kirim balik angka yang valid
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Item tidak ditemukan'
    ], 404);
}

public function checkout()
{
    // 1. Ambil item keranjang
    $cart_items = Cart::where('user_id', Auth::id())->with('menu')->get();
    
    // 2. Ambil SEMUA alamat user
    $user_addresses = \App\Models\UserAlamat::where('user_id', Auth::id())->get();
    
    // 3. Tentukan Selected Address
    $selected_address = $user_addresses->first();

    // 4. Hitung Subtotal
    $subtotal = $cart_items->sum(fn($i) => $i->quantity * $i->menu->price);

    // --- LOGIKA ONGKIR BARU ---
    // Cek jika ada alamat, ambil jaraknya. Jika tidak ada, default 0 km.
    $jarak = $selected_address ? $selected_address->jarak : 0;

    // Batasi jarak maksimal 7 km
    if ($jarak > 7) {
        $jarak_hitung = 7;
    } else {
        $jarak_hitung = $jarak;
    }

    // Hitung ongkir: Jarak x 2000
    $ongkir = $jarak_hitung * 2000;
    
    $total_pembayaran = $subtotal + $ongkir;

    // 5. Kirim ke view
    return view('checkout', compact(
        'cart_items', 
        'user_addresses', 
        'selected_address', 
        'subtotal', 
        'ongkir', 
        'total_pembayaran',
        //'jarak' // Opsional: kirim data jarak untuk ditampilkan di struk
    ));
}
    // Menghapus item
    public function removeFromCart($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Produk dihapus dari troli');
    }
}