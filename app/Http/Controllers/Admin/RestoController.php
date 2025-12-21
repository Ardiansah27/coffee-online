<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestoController extends Controller
{
    public function index()
    {
        // Ambil data resto pertama
        $resto = DB::table('resto_settings')->first();
        return view('admin.resto_setting', compact('resto'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'alamat_lengkap' => 'required'
        ]);

        // Update data dengan ID 1 (karena cuma ada 1 resto)
        DB::table('resto_settings')->updateOrInsert(
            ['id' => 1],
            [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'alamat_lengkap' => $request->alamat_lengkap,
                'updated_at' => now()
            ]
        );

        return response()->json(['success' => 'Lokasi resto berhasil diperbarui!']);
    }
}