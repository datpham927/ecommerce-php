<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminControllers extends Controller
{
    protected $admin;

    function __construct(admin $admin){
        $this->admin=$admin;
    }

      
    function login(){
        $idAdmin=Session::get('admin_id');
        if(!$idAdmin){
            return view('admin.login');
        }
        return view('admin.dashboard');
     }
     
     function storeLogin(Request $request)
     {
         $admin_email = $request->input('admin_email');
         $admin_password = $request->input('admin_password');
         // Tìm kiếm
         $foundAdmin = $this->admin
             ->where('admin_email', $admin_email)
             ->first();
         // Kiểm tra mật khẩu
         if ($foundAdmin && Hash::check($admin_password, $foundAdmin->admin_password)) {
             Session::put('admin_id', $foundAdmin->id);
             Session::put('admin_name', $foundAdmin->admin_name);
             return redirect()->route("admin.dashboard");
         } 
         Session::put('message', "Tài khoản hoặc mật khẩu không chính xác!");
         return redirect()->route("admin.login");
     }
     
     function logout(){
        Session::put('admin_id',null);
        return redirect()->route("admin.dashboard");
     }
    function showDashboard(){
        $idAdmin=Session::get('admin_id');
        if(!$idAdmin){
             return redirect()->route("admin.login");
        }
        $admin=$this->admin->find($idAdmin);
        
        return view('admin.dashboard');
     }
}