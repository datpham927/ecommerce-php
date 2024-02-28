<?php 
namespace App\Traits;
use Illuminate\Support\Facades\Session;

trait AdminAuthenticationTrait
{
    public function authenticateLogin()
    {
        $adminId = Session::get('admin_id');
        if ($adminId === null) { 
            return redirect()->route('admin.login')->send();;
        } 
    }
}
