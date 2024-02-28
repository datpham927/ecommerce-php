<?php

use App\Http\Controllers\AdminControllers;
use App\Http\Controllers\BrandControllers;
use App\Http\Controllers\CategoryControllers;
use App\Http\Controllers\HomeControllers;
use App\Http\Controllers\ProductControllers;
use App\Http\Controllers\SliderControllers;
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
        Route::get('/', [CategoryControllers::class, 'index'])->name("category.index");
        Route::get('/add', [CategoryControllers::class, 'create'])->name("category.add"); 
        Route::post('/store', [CategoryControllers::class, 'store'])->name("category.store");
        Route::get('/edit/{id}', [CategoryControllers::class, 'edit'])->name("category.edit"); 
        Route::post('/update/{id}', [CategoryControllers::class, 'update'])->name("category.update");
        Route::delete('/delete/{id}', [CategoryControllers::class, 'delete'])->name("category.delete");
        Route::get('/danh-muc-san-pham/{slug}/{cid}', [CategoryControllers::class, 'showCategoryHome'])->name("category.show_home");
    }); 

    Route::prefix('/slider')->group(function () {
        Route::get('/', [SliderControllers::class, 'index'])->name("slider.index");
        Route::get('/add', [SliderControllers::class, 'create'])->name("slider.add"); 
        Route::post('/store', [SliderControllers::class, 'store'])->name("slider.store");
        Route::get('/edit/{id}', [SliderControllers::class, 'edit'])->name("slider.edit"); 
        Route::post('/update/{id}', [SliderControllers::class, 'update'])->name("slider.update");
        Route::delete('/delete/{id}', [SliderControllers::class, 'delete'])->name("slider.delete");
    }); 


    Route::prefix('/brand')->group(function () {
        Route::get('/', [BrandControllers::class, 'index'])->name("brand.index");
        Route::get('/add', [BrandControllers::class, 'create'])->name("brand.add"); 
        Route::post('/store', [BrandControllers::class, 'store'])->name("brand.store");
        Route::get('/edit/{id}', [BrandControllers::class, 'edit'])->name("brand.edit"); 
        Route::post('/update/{id}', [BrandControllers::class, 'update'])->name("brand.update");
        Route::delete('/delete/{id}', [BrandControllers::class, 'delete'])->name("brand.delete");
        Route::get('/thuong-hieu-san-pham/{slug}/{bid}', [BrandControllers::class, 'showBrandyHome'])->name("brand.show_home");
  
    }); 
    Route::prefix('/product')->group(function () {
        Route::get('/', [ProductControllers::class, 'index'])->name("product.index");
        Route::get('/draft', [ProductControllers::class, 'draftList'])->name("product.draft");
        Route::post('/is_publish/{id}', [ProductControllers::class, 'isPublish'])->name("product.isPublish");
        Route::get('/add', [ProductControllers::class, 'create'])->name("product.add"); 
        Route::post('/store', [ProductControllers::class, 'store'])->name("product.store");
        Route::get('/edit/{id}', [ProductControllers::class, 'edit'])->name("product.edit"); 
        Route::post('/update/{id}', [ProductControllers::class, 'update'])->name("product.update");
        Route::delete('/delete/{id}', [ProductControllers::class, 'delete'])->name("product.delete");
        Route::get('/deleted', [ProductControllers::class, 'productDeleted'])->name("product.deleted");
        Route::post('/restore/{id}', [ProductControllers::class, 'restore'])->name("product.restore");
        Route::get('/{slug}/{pid}', [ProductControllers::class, 'detailProduct'])->name("product.detail");
    }); 
});