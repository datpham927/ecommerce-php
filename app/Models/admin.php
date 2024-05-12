<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Support\Facades\Auth;

class admin extends Model implements Authenticatable
{
    use AuthenticableTrait;
    protected $guarded = [];
    use HasFactory;
    public function getAuthPassword()
    {
        return $this->admin_password;
    }

    
    public function roles()
    {
        return $this->belongsToMany(
            Role::class, 
            'admin_roles', 
            'ar_admin_id',  // Khóa ngoại của bảng user trong bảng trung gian
            'ar_role_id',    // Khóa ngoại của bảng role trong bảng trung gian
        );
    }
  
    public function hasRole($keyCodePermission)
    {
        // Lấy tất cả các role của người dùng
        $roles =$this->roles;
        // Lặp qua tất cả các role
        foreach ($roles as $role) {
            // Lấy tất cả các permission của role
            $permissions = $role->permissions;
            
            // Lặp qua tất cả các permission
            foreach ($permissions as $permission) {
                // Kiểm tra xem có permission nào có keyCodePermission không
                dump([$permission->pms_key_code , $keyCodePermission]);
                if ($permission->pms_key_code === $keyCodePermission) {
                    return true; // Nếu có, trả về true
                }
            }
        }
        
        return false; // Nếu không tìm thấy, trả về false
    }
    
}
