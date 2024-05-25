<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Policies\BrandPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\RolePolicy;
use App\Policies\SliderPolicy;
use App\Policies\StaffPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Category' => 'App\Policies\CategoryPolicy',
        'App\Models\Slider' => 'App\Policies\SliderPolicy',
        
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // -----
        Gate::define('list_slider',[SliderPolicy::class, 'view']);
        Gate::define('add_slider',[SliderPolicy::class, 'create']);
        Gate::define('edit_slider',[SliderPolicy::class, 'update']);
        Gate::define('delete_slider',[SliderPolicy::class, 'delete']);

    // -------
        Gate::define('list_slider', [SliderPolicy::class, 'view']);
        Gate::define('add_slider', [SliderPolicy::class, 'create']);
        Gate::define('edit_slider', [SliderPolicy::class, 'update']);
        Gate::define('delete_slider', [SliderPolicy::class, 'delete']);

// Staff
Gate::define('list_staff', [StaffPolicy::class, 'view']);
Gate::define('add_staff', [StaffPolicy::class, 'create']);
Gate::define('edit_staff', [StaffPolicy::class, 'update']);
Gate::define('delete_staff', [StaffPolicy::class, 'delete']);

// Customer
Gate::define('list_customer', [CustomerPolicy::class, 'view']);
Gate::define('add_customer', [CustomerPolicy::class, 'create']);
Gate::define('edit_customer', [CustomerPolicy::class, 'update']);
Gate::define('delete_customer', [CustomerPolicy::class, 'delete']);

// Role
Gate::define('list_role', [RolePolicy::class, 'view']);
Gate::define('add_role', [RolePolicy::class, 'create']);
Gate::define('edit_role', [RolePolicy::class, 'update']);
Gate::define('delete_role', [RolePolicy::class, 'delete']);

// Category
Gate::define('list_category', [CategoryPolicy::class, 'view']);
Gate::define('add_category', [CategoryPolicy::class, 'create']);
Gate::define('edit_category', [CategoryPolicy::class, 'update']);
Gate::define('delete_category', [CategoryPolicy::class, 'delete']);

// Brand
Gate::define('list_brand', [BrandPolicy::class, 'view']);
Gate::define('add_brand', [BrandPolicy::class, 'create']);
Gate::define('edit_brand', [BrandPolicy::class, 'update']);
Gate::define('delete_brand', [BrandPolicy::class, 'delete']);

// Product
Gate::define('list_product', [ProductPolicy::class, 'view']);
Gate::define('add_product', [ProductPolicy::class, 'create']);
Gate::define('edit_product', [ProductPolicy::class, 'update']);
Gate::define('delete_product', [ProductPolicy::class, 'delete']);

// Order
Gate::define('list_order', [OrderPolicy::class, 'view']);
Gate::define('add_order', [OrderPolicy::class, 'create']);
Gate::define('edit_order', [OrderPolicy::class, 'update']);
Gate::define('delete_order', [OrderPolicy::class, 'delete']);


    }
}