<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\UserAuthenticationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserControllers extends Controller
{

    use UserAuthenticationTrait;
    protected $user; 
    function __construct(User $user){
        $this->user=$user;
    } 
    function login(){
        $userId = Session::get('user_id');
        if ($userId!= null) { 
            return redirect()->back();
        }
        return view('pages.login');
     }
     
     function storeLogin(Request $request)
     {
         $user_email = $request->input('user_email');
         $user_password = $request->input('user_password');
         // Tìm kiếm
         $foundUser = $this->user
             ->where('user_email', $user_email)
             ->first();
         // Kiểm tra mật khẩu
         if ($foundUser && Hash::check($user_password, $foundUser->user_password)) {
             Session::put('user_id', $foundUser->id);
             Session::put('user_name', $foundUser->user_name);
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
        Session::put('user_id',null);
        Session::put('user_name',null);
        return redirect()->route("home.index");
     }
     function showProfile(){
        $this->authenticateLoginUser();
        $userId=Session::get('user_id');
        $user=$this->user->find($userId);
        return view('pages.profile',compact("user"));
     }


     function update(Request $request){
        $this->authenticateLoginUser();
        $data=$request->all();
        $userId=Session::get('user_id');
        $this->user->find($userId)->update($data);
        $user= $this->user->find($userId);
        return view('pages.profile',compact("user"));
     }




}