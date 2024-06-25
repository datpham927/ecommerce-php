<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    
    protected $guarded = [];
public function Product()
{
    return $this->belongsTo(product::class, 'od_item_product_id');
}
public function Order()
{
    return $this->belongsTo(Order::class, 'od_item_order_id');
}
}
