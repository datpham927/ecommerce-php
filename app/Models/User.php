<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'user_name',
        'user_email',
        'user_mobile',
        'user_image_url',
        'user_password',
        "user_province_id",
        "user_ward_id" ,
        "user_city_id" ,
        "user_google_id" ,
    ];
    // thêm mới try cập được password
    public function getAuthPassword()
    {
        return $this->user_password;
    }
    
    public function Orders()
    {
        return $this->hasMany(Order::class, 'od_user_id','id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'cart_user_id','id');
    }
    public function city()
    {
        return $this->hasOne(City::class, 'matp','user_city_id');
    }
    public function province()
    {
        return $this->hasOne(Province::class, 'maqh','user_province_id');
    }
    public function ward()
    {
        return $this->hasOne(Wards::class, 'xaid','user_ward_id');
    }
    public function roles()
    {
        return $this->belongsToMany(
            Role::class, 
            'user_roles', 
            'ur_user_id',  // Khóa ngoại của bảng user trong bảng trung gian
            'ur_role_id',    // Khóa ngoại của bảng role trong bảng trung gian
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
                if ($permission->pms_key_code === $keyCodePermission) {
                    return true; // Nếu có, trả về true
                }
            }
        }
        return false; // Nếu không tìm thấy, trả về false
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
   
}