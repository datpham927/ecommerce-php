<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function  Category()
    {
        return $this->belongsTo(Category::class, 'product_category_id');
    }

    public function  Brand()
    {
        return $this->belongsTo(brand::class, 'product_brand_id');
    }
}
