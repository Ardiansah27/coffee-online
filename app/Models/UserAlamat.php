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
        'label',
        'penerima',
        'telepon',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos'
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
