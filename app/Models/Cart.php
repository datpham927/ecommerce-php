<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable=[
        'cart_user_id','cart_product_id','cart_quantity','cart_size' 
    ];
    use HasFactory;

    public function Product()
    {
        return $this->belongsTo(product::class, 'cart_product_id');
    }
}
