<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function OrderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'od_detail_orderId','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'od_user_id');
    }
}