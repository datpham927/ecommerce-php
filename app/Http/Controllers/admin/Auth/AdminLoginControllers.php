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
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }
     
     function storeLogin(Request $request)
     {
        $admin_name = $request->input('admin_name');
        $admin_password = $request->input('admin_password');
        // được sử dụng để thử xác thực thông tin
        //  người dùng với vai trò cụ thể 
        //  (trong trường hợp này là vai trò admin)
        //  Auth::guard('admin'):  Laravel sẽ sử dụng bảng admins 
        //    trong cơ sở dữ liệu để tìm kiếm và xác thực người dùng.
        // thêm class Admin extends Model implements Authenticatable
            if (Auth::guard('admin')->attempt(['admin_name' => $admin_name, 'password' => $admin_password])) {
                    return redirect()->route('admin.dashboard');
            }
            Session::put('message', "Tài khoản hoặc mật khẩu không chính xác!");
            return redirect()->back();
 }
                    
     function logout(){
        Auth::guard('admin')->logout();
       return redirect()->route('admin.login');
     }
}
