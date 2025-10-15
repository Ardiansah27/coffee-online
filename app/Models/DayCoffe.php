<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayCoffe extends Model
{
    protected $table = 'day_coffe';
    protected $fillable = ['filename','title']; // sesuaikan fieldnya
}
