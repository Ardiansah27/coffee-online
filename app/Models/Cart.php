<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'carts';

    // Kolom yang boleh diisi
    protected $fillable = [
        'user_id',
        'menu_id',
        'quantity'
    ];

    /**
     * Hubungkan Cart dengan Menu
     * Ini agar kita bisa panggil $item->menu->name di view
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    /**
     * Hubungkan Cart dengan User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}