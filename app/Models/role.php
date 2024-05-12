<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Role extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'role_id';
    use HasFactory;

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class, 
            'permission_roles', 
            'pr_role_id',  // Khóa ngoại của bảng role trong bảng trung gian
            'pr_pms_id',    // Khóa ngoại của bảng permission trong bảng trung gian
        );
    }
}
 