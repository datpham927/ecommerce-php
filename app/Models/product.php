<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;
    use HasFactory;
    use SoftDeletes;

    public function  Category()
    {
        return $this->belongsTo(Category::class, 'product_category_id');
    }
    public function  Attribute()
    {
        return $this->hasMany(attribute::class, 'attribute_product_id','id');
    }
    public function  Brand()
    {
        return $this->belongsTo(brand::class, 'product_brand_id');
    }
    public function  Image()
    {
        return $this->hasMany(Images::class, 'image_product_id');
    }
    public function  Size()
    {
        return $this->hasMany(Size::class, 'size_product_id');
    }
    
}



