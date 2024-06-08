<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class,'comment_user_id');
    }
    public function commentChildren(){
        return $this->hasMany(Comment::class,'comment_parent_id')->orderBy("created_at","desc");
    }
    public function product(){
        return $this->belongsTo(product::class,'comment_product_id');
    }
}
