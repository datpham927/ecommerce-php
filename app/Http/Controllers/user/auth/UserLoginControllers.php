<?php

namespace App\Http\Controllers\user\auth;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use App\Models\User;
use App\Models\Wards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserLoginControllers extends Controller
{
    protected $user; 
    function __construct(User $user){
        $this->user=$user;
    } 
    function login(){
        
        if (Auth::check()) { 
            return redirect()->back();
        }
        return view('client.pages.login');
     }
     
     function storeLogin(Request $request)
     { 
        $user_email = $request->input('user_email');
        $user_password = $request->input('user_password'); 
            if (Auth::attempt(['user_email' => $user_email, 'password' => $user_password])) {
                Auth::user();  
                Session::put('user_id', Auth::user()->id);
                Session::put('user_name',Auth::user()->user_name);
                return redirect()->route("home.index");
            }  
         Session::put('message', "Tài khoản hoặc mật khẩu không chính xác!");
         return redirect()->route("user.login");
     }
     
     function register(){ 
        $adminId = Session::get('user_id');
        if ($adminId!= null) { 
            return redirect()->back();
        }
        return view('client.pages.register');
     }
     public function storeRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_email' => 'unique:users',
        ], [
            'user_email.unique' => 'Địa chỉ email đã tồn tại!',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $password = $request->input('user_password');
        $email=$request->input('user_email');
        $confirmPassword = $request->input('user_confirm_password');
        if ($password != $confirmPassword) {
            Session::put('message', "Mật khẩu xác nhận không chính xác!");
            return redirect()->back();
        } 
         $username = explode('@', $email)[0];
        $this->user->create([
            "user_email" =>$email,
            "user_name" =>$username,
            "user_password" => Hash::make($password),
        ]);
        return redirect()->route("user.login");
    }
     function logout(){
        Auth::logout();
        return redirect()->route("home.index");
     }
     function showProfile(){ 
        $cities= City::orderBy("matp",'asc')->get();
        $provinces= Province::orderBy("maqh",'asc')->get();
        $wards= Wards::orderBy("xaid",'asc')->get();
        $user=Auth::user();
        return view('client.pages.profile',compact("user",'cities','provinces','wards'));
     }


    
public function update(Request $request) {
    $user = Auth::user();
    $user->update([
        'user_mobile' => $request->user_mobile,
        'user_name' => $request->user_name,
        'user_city_id' => $request->city,
        'user_province_id' => $request->province,
        'user_ward_id' => $request->ward,
    ]); 
    return  redirect()->back()->with(['success'=>'Cập nhật thành công']);
}

}