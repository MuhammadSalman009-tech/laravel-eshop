<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table="orders";

    public function users(){
        $this->belongsTo(Order::class);
    }
    public function orderItem(){
        $this->hasMany(OrderItem::class);
    }
    public function shipping(){
        $this->hasOne(Shipping::class);
    }
    public function transaction(){
        $this->hasOne(Transaction::class);
    }

}
