<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function OrderItem()
    {
        return $this->hasMany(OrderItem::class, 'od_item_orderId','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'od_user_id');
    }
}