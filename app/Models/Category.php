<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    use HasFactory;

    // Mối quan hệ với chính nó
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'category_parent_id');
    }
}
