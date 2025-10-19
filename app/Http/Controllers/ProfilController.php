<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAlamat;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $alamat = $user->alamat; // ambil semua alamat user
        return view('profil', compact('user', 'alamat'));
    }

    public function storeAlamat(Request $request)
    {
        $request->validate([
            'label' => 'required',
            'penerima' => 'required',
            'telepon' => 'required',
            'alamat' => 'required'
        ]);

        UserAlamat::create([
            'user_id' => Auth::id(),
            'label' => $request->label,
            'penerima' => $request->penerima,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos
        ]);

        return redirect()->back()->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function deleteAlamat($id)
    {
        $alamat = UserAlamat::findOrFail($id);
        if ($alamat->user_id != Auth::id()) {
            abort(403);
        }
        $alamat->delete();
        return redirect()->back()->with('success', 'Alamat berhasil dihapus!');
    }
}
