<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class SystemControllers extends Controller
{
    function showDashboard(){
      
        return view('admin.dashboard');
     }
}
