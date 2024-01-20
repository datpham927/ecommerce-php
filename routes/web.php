<?php

use App\Http\Controllers\AdminControllers;
use App\Http\Controllers\CategoryController;
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

Route::prefix('admin')->group(function () {
    Route::get('/',[AdminControllers::class,'login'])->name('admin.login');
    Route::get('/dashboard',[AdminControllers::class,'showDashboard'])->name('admin.dashboard');
    Route::post('/store-login',[AdminControllers::class,'storeLogin'])->name('admin.storeLogin');
    Route::get('/logout',[AdminControllers::class,'logout'])->name('admin.logout');

    Route::prefix('/category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name("category.index");
        Route::get('/add', [CategoryController::class, 'create'])->name("category.add"); 
        Route::post('/store', [CategoryController::class, 'store'])->name("category.store");
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name("category.edit"); 
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name("category.update");
        Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name("category.delete");
    }); 
    
});