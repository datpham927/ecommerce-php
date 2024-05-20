<?php

namespace App\Http\Controllers\admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminLoginControllers extends Controller
{
    public function login()
    { 
        if (Auth::check()) { 
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }
     
     function storeLogin(Request $request)
     {
        $user_name = $request->input('user_name');
        $user_password = $request->input('user_password');
        // được sử dụng để thử xác thực thông tin
        //  người dùng với vai trò cụ thể 
        //  (trong trường hợp này là vai trò admin)
        //  Auth::guard('admin'):  Laravel sẽ sử dụng bảng admins 
        //    trong cơ sở dữ liệu để tìm kiếm và xác thực người dùng.
        // thêm class Admin extends Model implements Authenticatable
        if (Auth::attempt(['user_name' => $user_name, 'password' => $user_password])) {
            $request->session()->regenerate();
            $adminGuard = Auth::user();
            Session::put('user_id', $adminGuard->id);
            Session::put('user_name', $adminGuard->user_name);
            return redirect()->route('admin.dashboard');
        }
            Session::put('message', "Tài khoản hoặc mật khẩu không chính xác!");
            return redirect()->back();
 }
                    
     function logout(){
        Auth::logout();
       return redirect()->route('admin.login');
     }
}
