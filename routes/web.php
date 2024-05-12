<?php

use App\Http\Controllers\admin\Auth\AdminLoginControllers;
use App\Http\Controllers\admin\BrandControllers;
use App\Http\Controllers\admin\SystemControllers;
use App\Http\Controllers\admin\CategoryControllers;
use App\Http\Controllers\admin\OrderControllers;
use App\Http\Controllers\admin\PermissionControllers;
use App\Http\Controllers\admin\ProductControllers;
use App\Http\Controllers\admin\RoleControllers;
use App\Http\Controllers\admin\SliderControllers;
use App\Http\Controllers\admin\StaffControllers;
use App\Http\Controllers\user\auth\UserLoginControllers;
use App\Http\Controllers\user\CartControllers;
use App\Http\Controllers\user\HomeControllers;
use App\Http\Controllers\User\UserOrderControllers;
use App\Http\Controllers\user\UserProductControllers;
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

// admin
Route::get('/admin', [AdminLoginControllers::class, 'login'])->name('admin.login');
Route::post('/admin/store-login', [AdminLoginControllers::class, 'storeLogin'])->name('admin.storeLogin');

Route::middleware(['auth-admin'])->group(function () {
Route::prefix('admin')->group(function () { 
      
        Route::get('/dashboard', [SystemControllers::class, 'showDashboard'])->name('admin.dashboard');
        Route::get('/logout', [AdminLoginControllers::class, 'logout'])->name('admin.logout');
       
        Route::prefix('/staff')->group(function () {
            Route::get('/', [StaffControllers::class, 'index'])->name("staff.index");
            Route::get('/add', [StaffControllers::class, 'create'])->name("staff.add");
            Route::post('/store', [StaffControllers::class, 'store'])->name("staff.store");
            Route::get('/edit/{id}', [StaffControllers::class, 'edit'])->name("staff.edit");
            Route::post('/update/{id}', [StaffControllers::class, 'update'])->name("staff.update");
            Route::delete('/delete/{id}', [StaffControllers::class, 'delete'])->name("staff.delete");
            Route::post('/upload-image', [StaffControllers::class, 'uploadImage'])->name("staff.upload_image");
        });

        Route::prefix('/role')->group(function () {
            Route::get('/', [RoleControllers::class, 'index'])->name("role.index");
            Route::get('/add', [RoleControllers::class, 'create'])->name("role.add");
            Route::post('/store', [RoleControllers::class, 'store'])->name("role.store");
            Route::get('/edit/{id}', [RoleControllers::class, 'edit'])->name("role.edit");
            Route::post('/update/{id}', [RoleControllers::class, 'update'])->name("role.update");
            Route::delete('/delete/{id}', [RoleControllers::class, 'delete'])->name("role.delete");
        });

        Route::prefix('/permission')->group(function () {
            Route::get('/add', [PermissionControllers::class, 'create'])->name("permission.add");
            Route::post('/store', [PermissionControllers::class, 'store'])->name("permission.store");
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
            Route::get('/', [SliderControllers::class, 'index'])->name("slider.index")->middleware('can:list_slider');
            Route::get('/add', [SliderControllers::class, 'create'])->name("slider.add")->middleware('can:add_slider');
            Route::post('/store', [SliderControllers::class, 'store'])->name("slider.store")->middleware('can:add_slider');
            Route::get('/edit/{id}', [SliderControllers::class, 'edit'])->name("slider.edit")->middleware('can:edit_slider');
            Route::post('/update/{id}', [SliderControllers::class, 'update'])->name("slider.update")->middleware('can:edit_slider');
            Route::delete('/delete/{id}', [SliderControllers::class, 'delete'])->name("slider.delete")->middleware('can:delete_slider');
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
});

// client
Route::get('/',[HomeControllers::class,'index'])->name('home.index');
Route::prefix('/')->group(function () { 
    Route::prefix('/user')->group(function () { 
        Route::get('/login',[UserLoginControllers::class,'login'])->name('user.login');
        Route::post('/store-login',[UserLoginControllers::class,'storeLogin'])->name('user.store_login');
        Route::get('/register',[UserLoginControllers::class,'register'])->name('user.register');
        Route::get('/logout',[UserLoginControllers::class,'logout'])->name('user.logout');
        Route::post('/store-register',[UserLoginControllers::class,'storeRegister'])->name('user.store_register');
        Route::get('/profile', [UserLoginControllers::class, 'showProfile'])->name("user.profile")->middleware('auth');
        Route::post('/profile/update', [UserLoginControllers::class, 'update'])->name("user.update");
    }); 
    Route::prefix('/category')->group(function () { 
        Route::get('/danh-muc-san-pham/{slug}/{cid}', [HomeControllers::class, 'showCategoryHome'])->name("category.show_product_home");
    });  
    Route::prefix('/brand')->group(function () { 
        Route::get('/thuong-hieu-san-pham/{slug}/{bid}', [BrandControllers::class, 'showBrandHome'])->name("brand.show_product_home");
  }); 
    Route::prefix('/product')->group(function () { 
        Route::get('/{slug}/{pid}', [UserProductControllers::class, 'detailProduct'])->name("product.detail");
        Route::get('/search-result', [UserProductControllers::class, 'searchResult'])->name("product.search_result");
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
          Route::get('/', [UserOrderControllers::class, 'showOrder'])->name("order.order_list");
          Route::get('/confirm', [UserOrderControllers::class, 'showOrder'])->name("order.confirm");
          Route::get('/confirm-delivery', [UserOrderControllers::class, 'showOrder'])->name("order.confirm_delivery");
          Route::get('/delivering', [UserOrderControllers::class, 'showOrder'])->name("order.delivering");
          Route::get('/success', [UserOrderControllers::class, 'showOrder'])->name("order.success");
          Route::get('/canceled', [UserOrderControllers::class, 'showOrder'])->name("order.canceled");
        //   ------
         Route::post('/store', [UserOrderControllers::class, 'addOrder'])->name("order.add_order");
         Route::get('/view-checkout', [UserOrderControllers::class, 'viewCheckout'])->name("order.view_checkout");
         Route::put('/is-canceled/{oid}', [UserOrderControllers::class, 'isCanceled'])->name("order.isCanceled");
    }); 
}); 