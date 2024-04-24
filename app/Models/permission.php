<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permission extends Model
{
    protected $primaryKey = 'pms_id';
    protected $guarded = [];
    use HasFactory;
    function permissionChildren(){
        return $this->hasMany(permission::class,"pms_parent_id",'pms_id');
    }
}
