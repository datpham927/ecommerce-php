<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_role extends Model
{

    protected $primaryKey = 'ar_id';
    protected $guarded = [];
    use HasFactory;
}