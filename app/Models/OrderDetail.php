<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    
    protected $guarded = [];
public function Product()
{
    return $this->belongsTo(product::class, 'od_detail_productId');
}
public function Order()
{
    return $this->belongsTo(Order::class, 'od_detail_orderId');
}
}
