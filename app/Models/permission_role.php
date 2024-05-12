<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permission_role extends Model
{

    protected $primaryKey = 'pr_id';
    protected $guarded = [];
    use HasFactory;
}
