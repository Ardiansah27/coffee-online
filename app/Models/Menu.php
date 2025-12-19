<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu_coffee';

    protected $fillable = [
        'name',
        'category', 
        'price',
        'description',
        'image'
    ];

    /**
     * Accessor untuk format mata uang Rp
     * Jadi di blade cukup panggil $menu->formatted_price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Accessor untuk URL Gambar
     * Jadi jika gambar kosong, bisa kasih gambar default
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('images/menu/' . $this->image);
        }
        return asset('images/1766131151.jpg'); // Pastikan file ini ada
    }
}