<?php

namespace App\Http\Controllers\user\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        return view('pages.login');
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
        return view('pages.register');
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
        Session::put('user_id',null);
        Session::put('user_name',null);
        return redirect()->route("home.index");
     }
     function showProfile(){
      
        $userId=Session::get('user_id');
        $user=$this->user->find($userId);
        return view('pages.profile',compact("user"));
     }


     function update(Request $request){
      
        $data=$request->all();
        $userId=Session::get('user_id');
        $this->user->find($userId)->update($data);
        $user= $this->user->find($userId);
        return view('pages.profile',compact("user"));
     }

}
