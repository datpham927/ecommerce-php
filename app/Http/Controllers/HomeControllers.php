<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeControllers extends Controller
{
     function index(){
        return view('pages.home');
     }
}
