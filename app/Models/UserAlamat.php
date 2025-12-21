<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAlamat extends Model
{
    use HasFactory;

    protected $table = 'user_alamat';

   protected $fillable = [
    'user_id', 
    'label_alamat', 
    'nama_penerima', 
    'no_telepon', 
    'alamat_lengkap', 
    'kota', 
    'provinsi', 
    'kode_pos', 
    'latitude', 
    'longitude', 
    'jarak', 
    'is_utama'
];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
