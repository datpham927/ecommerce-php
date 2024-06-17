<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey='xaid';
    protected $table='devvn_xaphuongthitran';
}
