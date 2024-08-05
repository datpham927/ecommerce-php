<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setting extends Model
{
    protected $fillable = [
        'setting_company_name',
        'setting_slogan',
        'setting_logo',
        'setting_phone',
        'setting_email',
        'setting_address',
        "setting_map",
        "setting_prcode"
    ];
    use HasFactory;
}
