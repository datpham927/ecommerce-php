<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_role extends Model
{

    protected $primaryKey = 'ur_id';
    protected $guarded = [];
    use HasFactory;
}
