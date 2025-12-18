<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAlamat;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    // Tampilkan halaman profil
    public function index()
    {
        $user = Auth::user();

        // Ambil alamat utama (jika ada)
        $alamatUtama = UserAlamat::where('user_id', $user->id)
            ->where('is_utama', true)
            ->first();

        // Ambil semua alamat user
        $alamat = UserAlamat::where('user_id', $user->id)->get();

        return view('profil', compact('user', 'alamat', 'alamatUtama'));
    }

    // Tambah alamat via AJAX
    public function storeAlamat(Request $request)
    {
        $request->validate([
            'label' => 'required|string',
            'penerima' => 'required|string',
            'telepon' => 'required|string',
            'alamat' => 'required|string',
            'kota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kode_pos' => 'nullable|string',
        ]);

        // Tandai sebagai utama jika belum ada alamat utama
        $isUtama = !UserAlamat::where('user_id', Auth::id())->where('is_utama', true)->exists();

        $alamat = UserAlamat::create([
            'user_id' => Auth::id(),
            'label' => $request->label,
            'penerima' => $request->penerima,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos,
            'is_utama' => $isUtama,
        ]);

        // Kembalikan JSON untuk AJAX
        return response()->json([
            'success' => 'Alamat berhasil ditambahkan!',
            'alamat' => $alamat
        ]);
    }

    // Set alamat utama via AJAX
    public function setAlamatUtama($id)
    {
        $userId = Auth::id();

        // Reset alamat utama lama
        UserAlamat::where('user_id', $userId)->update(['is_utama' => false]);

        // Set alamat utama baru
        $alamat = UserAlamat::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $alamat->update(['is_utama' => true]);

        return response()->json(['success' => 'Alamat utama berhasil diubah!']);
    }

    // Hapus alamat via AJAX
    public function deleteAlamat($id)
    {
        $alamat = UserAlamat::findOrFail($id);

        if ($alamat->user_id != Auth::id()) {
            return response()->json(['error' => 'Akses ditolak!'], 403);
        }

        $alamat->delete();

        return response()->json(['success' => 'Alamat berhasil dihapus!']);
    }

    public function updateProfil(Request $request)
{
    /** @var \App\Models\User $user */


    $user = Auth::user();
    $user->name = $request->name;
    $user->phone = $request->phone;
    $user->save();

    // Update alamat utama jika ada
    if($request->alamat_id){
        UserAlamat::where('user_id', Auth::id())->update(['is_utama' => false]);
        UserAlamat::where('id', $request->alamat_id)->update(['is_utama' => true]);
    }

    return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
}


}
 