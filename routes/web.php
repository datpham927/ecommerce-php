<?php

use App\Http\Controllers\AdminControllers;
use App\Http\Controllers\BrandControllers;
use App\Http\Controllers\CartControllers;
use App\Http\Controllers\CategoryControllers;
use App\Http\Controllers\HomeControllers;
use App\Http\Controllers\OrderControllers;
use App\Http\Controllers\ProductControllers;
use App\Http\Controllers\RoleControllers;
use App\Http\Controllers\SliderControllers;
use App\Http\Controllers\UserControllers;
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

//  admin
Route::prefix('admin')->group(function () {
    Route::get('/',[AdminControllers::class,'login'])->name('admin.login');
    Route::get('/dashboard',[AdminControllers::class,'showDashboard'])->name('admin.dashboard');
    Route::post('/store-login',[AdminControllers::class,'storeLogin'])->name('admin.storeLogin');
    Route::get('/logout',[AdminControllers::class,'logout'])->name('admin.logout');
     

    Route::prefix('/role')->group(function () {
        Route::get('/', [RoleControllers::class, 'index'])->name("role.index");
        Route::get('/add', [RoleControllers::class, 'create'])->name("role.add"); 
        Route::post('/store', [RoleControllers::class, 'store'])->name("role.store");
        Route::get('/edit/{id}', [RoleControllers::class, 'edit'])->name("role.edit"); 
        Route::post('/update/{id}', [RoleControllers::class, 'update'])->name("role.update");
        Route::delete('/delete/{id}', [RoleControllers::class, 'delete'])->name("role.delete");
    }); 

    Route::prefix('/category')->group(function () {
        Route::get('/', [CategoryControllers::class, 'index'])->name("category.index");
        Route::get('/add', [CategoryControllers::class, 'create'])->name("category.add"); 
        Route::post('/store', [CategoryControllers::class, 'store'])->name("category.store");
        Route::get('/edit/{id}', [CategoryControllers::class, 'edit'])->name("category.edit"); 
        Route::post('/update/{id}', [CategoryControllers::class, 'update'])->name("category.update");
        Route::delete('/delete/{id}', [CategoryControllers::class, 'delete'])->name("category.delete");
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
    }); 

    Route::prefix('/order')->group(function () { 
        Route::get('/', [OrderControllers::class, 'index'])->name("admin.order.index");
        Route::get('/confirm', [OrderControllers::class, 'index'])->name("admin.order.confirm");
        Route::get('/confirm-delivery', [OrderControllers::class, 'index'])->name("admin.order.confirm_delivery");
        Route::get('/delivered', [OrderControllers::class, 'index'])->name("admin.order.delivered");
        Route::get('/success', [OrderControllers::class, 'index'])->name("admin.order.success");
        Route::get('/canceled', [OrderControllers::class, 'index'])->name("admin.order.canceled");
        Route::get('/detail/{oid}', [OrderControllers::class, 'getOrderDetailByAdmin'])->name("admin.order.detail");
        //    xác nhận đơn hàng
        Route::put('/is-confirm/{oid}', [OrderControllers::class, 'isConfirm'])->name("admin.order.status.confirmation");
        Route::put('/is-confirm-delivery/{oid}', [OrderControllers::class, 'isConfirmDelivery'])->name("admin.order.status.confirm_delivery");
        Route::put('/is-delivered/{oid}', [OrderControllers::class, 'isDelivered'])->name("admin.order.status.delivered");
        Route::post('/is-canceled/{oid}', [OrderControllers::class, 'isCanceled'])->name("order.is_canceled");
    }); 
});

// client
Route::get('/',[HomeControllers::class,'index'])->name('home.index');
Route::prefix('/')->group(function () { 
    Route::prefix('/user')->group(function () { 
        Route::get('/login',[UserControllers::class,'login'])->name('user.login');
        Route::post('/store-login',[UserControllers::class,'storeLogin'])->name('user.store_login');
        Route::get('/register',[UserControllers::class,'register'])->name('user.register');
        Route::get('/logout',[UserControllers::class,'logout'])->name('user.logout');
        Route::post('/store-register',[UserControllers::class,'storeRegister'])->name('user.store_register');
        Route::get('/profile', [UserControllers::class, 'showProfile'])->name("user.profile");
        Route::post('/profile/update', [UserControllers::class, 'update'])->name("user.update");
    }); 
    

    Route::prefix('/category')->group(function () { 
        Route::get('/danh-muc-san-pham/{slug}/{cid}', [CategoryControllers::class, 'showCategoryHome'])->name("category.show_product_home");
    });  
    Route::prefix('/brand')->group(function () { 
        Route::get('/thuong-hieu-san-pham/{slug}/{bid}', [BrandControllers::class, 'showBrandHome'])->name("brand.show_product_home");
  }); 
    Route::prefix('/product')->group(function () { 
        Route::get('/{slug}/{pid}', [ProductControllers::class, 'detailProduct'])->name("product.detail");
        Route::get('/search-result', [ProductControllers::class, 'searchResult'])->name("product.search_result");
    }); 
    Route::prefix('/cart')->group(function () { 
        Route::get('/', [CartControllers::class, 'viewListCart'])->name("cart.view_Cart");
        Route::post('/add-to-cart', [CartControllers::class, 'addToCart'])->name("cart.add_cart");
        Route::post('/increase/{cid}', [CartControllers::class, 'increase'])->name("cart.increase");
        Route::post('/decrease/{cid}', [CartControllers::class, 'decrease'])->name("cart.decrease");
        Route::delete('/delete/{cid}', [CartControllers::class, 'delete'])->name("cart.delete");
    }); 
    Route::prefix('/order')->group(function () { 
        // trạng thái
          Route::get('/', [OrderControllers::class, 'showOrder'])->name("order.order_list");
          Route::get('/confirm', [OrderControllers::class, 'showOrder'])->name("order.confirm");
          Route::get('/confirm-delivery', [OrderControllers::class, 'showOrder'])->name("order.confirm_delivery");
          Route::get('/delivering', [OrderControllers::class, 'showOrder'])->name("order.delivering");
          Route::get('/success', [OrderControllers::class, 'showOrder'])->name("order.success");
          Route::get('/canceled', [OrderControllers::class, 'showOrder'])->name("order.canceled");
        //   ------
        Route::post('/store', [OrderControllers::class, 'addOrder'])->name("order.add_order");
        Route::get('/view-checkout', [OrderControllers::class, 'viewCheckout'])->name("order.view_checkout");
         Route::put('/is-canceled/{oid}', [OrderControllers::class, 'isCanceled'])->name("order.isCanceled");
    }); 
}); 