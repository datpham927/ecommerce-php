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
use App\Http\Controllers\admin\CustomerControllers;
use App\Http\Controllers\admin\DeliveryControllers;
use App\Http\Controllers\admin\SettingControllers;
use App\Http\Controllers\admin\UploadImageControllers;
use App\Http\Controllers\CrawlerControllers;
use App\Http\Controllers\MomoControllers;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\user\auth\UserLoginControllers;
use App\Http\Controllers\user\CartControllers;
use App\Http\Controllers\user\CommentControllers;
use App\Http\Controllers\user\HomeControllers;
use App\Http\Controllers\User\UserOrderControllers;
use App\Http\Controllers\user\UserProductControllers;
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
Route::get('/crawler', [CrawlerControllers::class, 'crawler'])->name('crawler.index');
// admin
Route::get('/admin', [AdminLoginControllers::class, 'login'])->name('admin.login');
Route::post('/admin/store-login', [AdminLoginControllers::class, 'storeLogin'])->name('admin.storeLogin');
Route::post('/upload-image', [UploadImageControllers ::class, 'uploadImage'])->name("upload_image");
Route::put('/is-watched/{nid}', [NotificationController ::class, 'isWatched'])->name("notification.is-watched");

Route::middleware(['auth-admin'])->group(function () {
Route::prefix('admin')->group(function () { 
        Route::get('/setting', [SettingControllers::class, 'index'])->name('admin.setting');
        Route::put('/setting/store', [SettingControllers::class, 'store'])->name('admin.setting.store');
        Route::get('/dashboard', [SystemControllers::class, 'showDashboard'])->name('admin.dashboard');
        Route::get('/chart_filter_by_date', [SystemControllers::class, 'chart_filter_by_date'])->name('admin.dashboard.chart_filter_by_date');
        Route::get('/logout', [AdminLoginControllers::class, 'logout'])->name('admin.logout');
        Route::prefix('/delivery')->group(function () {
            Route::get('/', [DeliveryControllers::class, 'index'])->name("delivery.index");
            Route::get('/city', [DeliveryControllers::class, 'city']);
            Route::post('/select-delivery', [DeliveryControllers::class, 'selectDelivery']);
            Route::post('/add', [DeliveryControllers::class, 'add'])->name("delivery.add");
            Route::put('/update/{id}', [DeliveryControllers::class, 'update'])->name("delivery.update");
        });
        // quản lý nhân viên
        Route::prefix('/staff')->group(function () {
            Route::get('/', [StaffControllers::class, 'index'])->name("staff.index") ;
            Route::get('/add', [StaffControllers::class, 'create'])->name("staff.add")->middleware('can:add_staff');
            Route::post('/store', [StaffControllers::class, 'store'])->name("staff.store")->middleware('can:add_staff');
            Route::get('/edit/{id}', [StaffControllers::class, 'edit'])->name("staff.edit")->middleware('can:list_staff');
            Route::post('/update/{id}', [StaffControllers::class, 'update'])->name("staff.update")->middleware('can:edit_staff');
            Route::delete('/delete/{id}', [StaffControllers::class, 'delete'])->name("staff.delete")->middleware('can:delete_staff');
        });
        // quản lý khách hàng
        route::prefix('/customer')->group(function () {
            Route::get('/', [CustomerControllers::class, 'index'])->name("customer.index")->middleware('can:list_customer');
            Route::get('/add', [CustomerControllers::class, 'create'])->name("customer.add")->middleware('can:add_customer');
            Route::post('/store', [CustomerControllers::class, 'store'])->name("customer.store")->middleware('can:add_customer');
            Route::get('/edit/{id}', [CustomerControllers::class, 'edit'])->name("customer.edit")->middleware('can:edit_customer');
            Route::post('/update/{id}', [CustomerControllers::class, 'update'])->name("customer.update")->middleware('can:edit_customer');
            Route::delete('/delete/{id}', [CustomerControllers::class, 'delete'])->name("customer.delete")->middleware('can:delete_customer');
            Route::post('/is-active/{id}', [CustomerControllers::class, 'isActive'])->name("customer.is_active")->middleware('can:edit_customer');
            Route::post('/is-block/{id}', [CustomerControllers::class, 'isBlock'])->name("customer.is_block")->middleware('can:edit_customer');
        });
 
        Route::prefix('/role')->group(function () {
            Route::get('/', [RoleControllers::class, 'index'])->name("role.index") ;
            Route::get('/add', [RoleControllers::class, 'create'])->name("role.add")->middleware('can:add_role');
            Route::post('/store', [RoleControllers::class, 'store'])->name("role.store")->middleware('can:add_role');
            Route::get('/edit/{id}', [RoleControllers::class, 'edit'])->name("role.edit") ;
            Route::post('/update/{id}', [RoleControllers::class, 'update'])->name("role.update") ;
            Route::delete('/delete/{id}', [RoleControllers::class, 'delete'])->name("role.delete")->middleware('can:delete_role');
        });

        Route::prefix('/permission')->group(function () {
            Route::get('/add', [PermissionControllers::class, 'create'])->name("permission.add");
            Route::post('/store', [PermissionControllers::class, 'store'])->name("permission.store");
        });

        Route::prefix('/category')->group(function () {
            Route::get('/', [CategoryControllers::class, 'index'])->name("category.index")->middleware('can:list_category');
            Route::get('/add', [CategoryControllers::class, 'create'])->name("category.add")->middleware('can:add_category');
            Route::post('/store', [CategoryControllers::class, 'store'])->name("category.store")->middleware('can:add_category');
            Route::get('/edit/{id}', [CategoryControllers::class, 'edit'])->name("category.edit")->middleware('can:edit_category');
            Route::post('/update/{id}', [CategoryControllers::class, 'update'])->name("category.update")->middleware('can:edit_category');
            Route::delete('/delete/{id}', [CategoryControllers::class, 'delete'])->name("category.delete")->middleware('can:delete_category');
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
            Route::get('/', [BrandControllers::class, 'index'])->name("brand.index")->middleware('can:list_brand');
            Route::get('/add', [BrandControllers::class, 'create'])->name("brand.add")->middleware('can:add_brand');
            Route::post('/store', [BrandControllers::class, 'store'])->name("brand.store")->middleware('can:add_brand');
            Route::get('/edit/{id}', [BrandControllers::class, 'edit'])->name("brand.edit")->middleware('can:edit_brand');
            Route::post('/update/{id}', [BrandControllers::class, 'update'])->name("brand.update")->middleware('can:edit_brand');
            Route::delete('/delete/{id}', [BrandControllers::class, 'delete'])->name("brand.delete")->middleware('can:delete_brand');
        });

        Route::prefix('/product')->group(function () {
            Route::get('/', [ProductControllers::class, 'index'])->name("product.index")->middleware('can:list_product');
            Route::get('/draft', [ProductControllers::class, 'draftList'])->name("product.draft")->middleware('can:list_product');
            Route::post('/is_publish/{id}', [ProductControllers::class, 'isPublish'])->name("product.isPublish")->middleware('can:edit_product');
            Route::get('/add', [ProductControllers::class, 'create'])->name("product.add")->middleware('can:add_product');
            Route::post('/store', [ProductControllers::class, 'store'])->name("product.store")->middleware('can:add_product');
            Route::get('/edit/{id}', [ProductControllers::class, 'edit'])->name("product.edit")->middleware('can:edit_product');
            Route::post('/update/{id}', [ProductControllers::class, 'update'])->name("product.update")->middleware('can:edit_product');
            Route::delete('/delete/{id}', [ProductControllers::class, 'delete'])->name("product.delete")->middleware('can:delete_product');
            Route::get('/deleted', [ProductControllers::class, 'productDeleted'])->name("product.deleted")->middleware('can:list_product');
            Route::post('/restore/{id}', [ProductControllers::class, 'restore'])->name("product.restore")->middleware('can:edit_product');
        });

        Route::prefix('/order')->group(function () {
            Route::get('/', [OrderControllers::class, 'index'])->name("admin.order.index")->middleware('can:list_order');
            Route::get('/confirm', [OrderControllers::class, 'index'])->name("admin.order.confirm")->middleware('can:list_order');
            Route::get('/confirm-delivery', [OrderControllers::class, 'index'])->name("admin.order.confirm_delivery")->middleware('can:list_order');
            Route::get('/delivered', [OrderControllers::class, 'index'])->name("admin.order.delivered")->middleware('can:list_order');
            Route::get('/success', [OrderControllers::class, 'index'])->name("admin.order.success")->middleware('can:list_order');
            Route::get('/canceled', [OrderControllers::class, 'index'])->name("admin.order.canceled")->middleware('can:list_order');
            Route::get('/detail/{oid}', [OrderControllers::class, 'getOrderItemByAdmin'])->name("admin.order.detail")->middleware('can:list_order');
            //    xác nhận đơn hàng
            Route::put('/is-confirm/{oid}', [OrderControllers::class, 'confirmOrderStatus'])->name("admin.order.status.confirmation")->middleware('can:edit_order');
            Route::put('/is-confirm-delivery/{oid}', [OrderControllers::class, 'confirmOrderStatus'])->name("admin.order.status.confirm_delivery")->middleware('can:edit_order');
            Route::put('/is-delivered/{oid}', [OrderControllers::class, 'confirmOrderStatus'])->name("admin.order.status.delivered")->middleware('can:edit_order');
            Route::post('/is-canceled/{oid}', [OrderControllers::class, 'confirmOrderStatus'])->name("order.is_canceled")->middleware('can:edit_order');
        }); 
});
});

// client
Route::get('/',[HomeControllers::class,'index'])->name('home.index');
Route::prefix('/')->group(function () { 
    Route::prefix('/user')->group(function () { 
        Route::get('/login',[UserLoginControllers::class,'login'])->name('user.login');
        Route::post('/store-login',[UserLoginControllers::class,'storeLogin'])->name('user.store_login');
        Route::get('login/google', [UserLoginControllers::class, 'redirectToGoogle'])->name('user.login.google');
        Route::get('login/google/callback', [UserLoginControllers::class, 'handleGoogleCallback']);
        Route::get('/register',[UserLoginControllers::class,'register'])->name('user.register');
        Route::get('/logout',[UserLoginControllers::class,'logout'])->name('user.logout');
        Route::post('/store-register',[UserLoginControllers::class,'storeRegister'])->name('user.store_register');
        Route::get('/profile', [UserLoginControllers::class, 'showProfile'])->middleware('auth')->name("user.profile");
        Route::post('/profile/update', [UserLoginControllers::class, 'update'])->middleware('auth')->name("user.update");
        Route::post('profile/select-address', [DeliveryControllers::class, 'selectDelivery']);
    
        Route::prefix('/order')->middleware('auth')->group(function () { 
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
    Route::prefix('/category')->group(function () { 
        Route::get('/danh-muc-san-pham/{slug}/{cid}', [HomeControllers::class, 'showCategoryHome'])->name("category.show_product_home");
    });  
    Route::prefix('/brand')->group(function () { 
        Route::get('/thuong-hieu-san-pham/{slug}/{bid}', [HomeControllers::class, 'showBrandHome'])->name("brand.show_product_home");
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




    Route::prefix('/comment')->middleware('auth')->group(function () { 
        Route::post('/add/{pid}', [CommentControllers::class, 'create'])->name("comment.add");
        Route::post('/add/{pid}/{cid}', [CommentControllers::class, 'createCommentChildren'])->name("comment.add-children");
        Route::delete('/delete/{cid}', [CommentControllers::class, 'delete'])->name("comment.delete");
    }); 
}); 
// auth google
 
// -- payment
Route::get('/return/momo',[MomoControllers::class,'momo_return'])->name('momo.momo_return');
Route::get('/return/momo_ipn',[MomoControllers::class,'momo_ipn'])->name('momo.momo_ipn');