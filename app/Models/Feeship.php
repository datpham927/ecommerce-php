<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function City()
    {
        return $this->belongsTo(City::class, 'matp');
    }
    public function Province()
    {
        return $this->belongsTo(Province::class, 'maqh');
    }

    public function Ward()
    {
        return $this->belongsTo(Wards::class, 'xaid');
    }
}
