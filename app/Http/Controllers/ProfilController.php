<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAlamat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
   public function index()
{
    $user = Auth::user();
    $alamat = UserAlamat::where('user_id', $user->id)->get();
    
    // Ambil data resto pertama
    $resto = DB::table('resto_settings')->first(); 

    return view('profil', compact('user', 'alamat', 'resto'));
}

public function storeAlamat(Request $request)
{
    try {
        // 1. Validasi (tambahkan lat & lng agar wajib diisi)
        $request->validate([
            'label'    => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'telepon'  => 'required|string|max:20',
            'alamat'   => 'required',
            'latitude' => 'required', // Tambahkan ini
            'longitude'=> 'required', // Tambahkan ini
            'jarak'    => 'required', 
        ]);

        // 2. Simpan ke database
        $alamat = UserAlamat::create([
            'user_id'        => auth()->id(),
            'label_alamat'   => $request->label,
            'nama_penerima'  => $request->penerima,
            'no_telepon'     => $request->telepon,
            'alamat_lengkap' => $request->alamat,
            'kota'           => $request->kota,
            'provinsi'       => $request->provinsi,
            'kode_pos'       => $request->kode_pos,
            'latitude'       => $request->latitude, // Simpan latitude
            'longitude'      => $request->longitude, // Simpan longitude
            'jarak'          => $request->jarak,
            // Jika ini alamat pertama, otomatis jadi alamat utama (1)
            'is_utama'       => UserAlamat::where('user_id', auth()->id())->count() == 0 ? 1 : 0,
        ]);

        return response()->json([
            'success' => 'Alamat berhasil disimpan!',
            'alamat'  => $alamat
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Gagal menyimpan: ' . $e->getMessage()
        ], 500);
    }
}

public function createAlamat()
{
    $resto = DB::table('resto_settings')->first(); 
    
    // Hapus 'user.' karena file ada di luar folder user
    return view('alamat_create', compact('resto')); 
}

    public function setAlamatUtama($id)
    {
        $userId = Auth::id();
        UserAlamat::where('user_id', $userId)->update(['is_utama' => false]);

        $alamat = UserAlamat::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $alamat->update(['is_utama' => true]);

        return response()->json(['success' => 'Alamat utama berhasil diubah!']);
    }

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

    try {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        // 2. Update Data Text
        $user->name = $request->name;
        $user->phone = $request->phone;

        // 3. Handle Update Foto Profil
        if ($request->hasFile('profile_picture')) {
            // Hapus foto lama jika bukan default
            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                if (!str_contains($user->profile_picture, 'default-user.png')) {
                    unlink(public_path($user->profile_picture));
                }
            }

            $file = $request->file('profile_picture');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $nama_file);
            
            $user->profile_picture = 'uploads/profile/' . $nama_file;
        }

        $user->save();

        return redirect()->back()->with('success', 'Perubahan data berhasil disimpan!');

    } catch (\Exception $e) {
        // Jika error, kembali dengan pesan error
        return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
    }
} // <--- Pastikan ada ini untuk tutup fungsi

} // <--- Pastikan ada ini untuk tutup class di paling akhir file