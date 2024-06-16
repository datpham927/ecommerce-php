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
        if (Auth::attempt(['user_name' => $user_name, 'password' => $user_password])) {
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
