<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'alamat_id', 'order_number', 'subtotal', 
        'ongkir', 'total_pembayaran', 'payment_method', 'status'
    ];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function alamat() {
        return $this->belongsTo(UserAlamat::class, 'alamat_id');
    }
}