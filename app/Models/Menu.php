<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu_coffee'; // sesuaikan dengan nama tabel kamu

    protected $fillable = [
        'name',
        'price',
        'description',
        'image'
    ];
}
