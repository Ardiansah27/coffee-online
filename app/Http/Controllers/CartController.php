<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu; 
use App\Models\Cart; 
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserAlamat; // Tambahkan ini agar tidak error
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        $cart_items = Cart::where('user_id', Auth::id())->with('menu')->get();
        $user_addresses = UserAlamat::where('user_id', Auth::id())->get();
        
        $selected_address = $user_addresses->where('is_utama', 1)->first() ?: $user_addresses->first();

        // Pakai 'menu' sesuai relasi di index
        $subtotal = $cart_items->sum(fn($i) => $i->quantity * $i->menu->price);

        $jarak = $selected_address ? $selected_address->jarak : 0;
        $jarak_hitung = min(7, $jarak); // Lebih simpel pakai min()
        $ongkir = $jarak_hitung * 2000; 
        
        $total_pembayaran = $subtotal + $ongkir;

        return view('checkout', compact(
            'cart_items', 'user_addresses', 'selected_address', 
            'subtotal', 'ongkir', 'total_pembayaran'
        ));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'alamat_id' => 'required',
        ]);

        $user = Auth::user();
        // Sesuai dengan fungsi checkout, gunakan with('menu')
        $cartItems = Cart::where('user_id', $user->id)->with('menu')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang Anda kosong.');
        }

        $alamat = UserAlamat::findOrFail($request->alamat_id);
        
        // Hitung ulang biaya untuk keamanan database
        $subtotal = $cartItems->sum(fn($item) => $item->menu->price * $item->quantity);
        $ongkir = min(7, $alamat->jarak) * 2000; 

        // 1. Simpan ke tabel Orders
        $order = Order::create([
            'user_id' => $user->id,
            'alamat_id' => $request->alamat_id,
            'order_number' => 'SRG-' . strtoupper(Str::random(10)),
            'subtotal' => $subtotal,
            'ongkir' => $ongkir,
            'total_pembayaran' => $subtotal + $ongkir,
            'payment_method' => 'COD',
            'status' => 'pending',
        ]);

        // 2. Simpan ke tabel Order Items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->menu_id, // Pastikan ini menu_id sesuai tabel Cart
                'quantity' => $item->quantity,
                'price' => $item->menu->price, 
            ]);
        }

        // 3. Kosongkan Keranjang
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat! Admin akan segera memproses.');
    }

    public function removeFromCart($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Produk dihapus dari troli');
    }
}