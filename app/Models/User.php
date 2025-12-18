<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi mass-assignment.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'profile_picture',
        'google_id',
    ];

    /**
     * Relasi ke tabel user_alamat
     */
    public function alamat()
    {
        return $this->hasMany(UserAlamat::class, 'user_id');
    }

    /**
     * Kolom yang disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tipe data untuk casting.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
