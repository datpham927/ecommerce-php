<?php 
namespace App\Traits;
use Illuminate\Support\Facades\Session;

trait UserAuthenticationTrait
{
    public function authenticateLoginUser()
    {
        $user_id = Session::get('user_id');
        if ($user_id === null) { 
            return redirect()->route('home.index')->send();;
        }
    }
}
