<?php

use App\Http\Controllers\AdminControllers;
use App\Http\Controllers\HomeControllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[HomeControllers::class,'index'])->name('home.index');

Route::get('/admin',[AdminControllers::class,'index'])->name('admin.index');
Route::get('/dashboard',[AdminControllers::class,'showDashboard'])->name('admin.dashboard');;