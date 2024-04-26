<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\admin;
use App\Models\OrderDetail;
use App\Traits\AdminAuthenticationTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminControllers extends Controller
{

   
    protected $admin;

    function __construct(admin $admin){
        $this->admin=$admin;
    }

      
    public function login()
    {
        if (Auth::check()) {
            if (Auth::user()->user_type == 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('admin.login');
            }
        }
        return view('admin.login');
    }
    

     
     function storeLogin(Request $request)
     {
                if (Auth::attempt(['user_email' => $request->user_email, 'password' => $request->password])) {
                    return redirect()->route("admin.dashboard");
              } 
                Session::put('message', "Tài khoản hoặc mật khẩu không chính xác!");
                return redirect()->route("admin.login");
            }
                    
     function logout(){
        Auth::logout();
        return redirect()->route("admin.dashboard");
     }
    function showDashboard(){
        return view('admin.dashboard');
     }
    function revenue(){
        $idAdmin=Session::get('user_id');
        if(!$idAdmin){
             return redirect()->route("admin.login");
        }
        return view('admin.revenue');
     }
    function viewRevenue(Request $request){
        $idAdmin=Session::get('user_id');
        if(!$idAdmin){
             return redirect()->route("admin.login");
        }
        $orderDetails = OrderDetail::whereMonth('created_at', '=',$request['month'] )->get();
        $totalRevenue=0;
        foreach($orderDetails as $od){
            $totalRevenue+=$od->od_detail_quantity*$od->od_detail_price;
        }
        return view('admin.viewRevenue',compact("orderDetails",'totalRevenue'));
     }
}