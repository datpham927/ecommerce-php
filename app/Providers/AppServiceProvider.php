<?php

namespace App\Providers;

use App\Repository\Interfaces\BrandRepositoryInterface;
use App\Repository\Interfaces\CategoryRepositoryInterface;
use App\Repository\Interfaces\OrderRepositoryInterface;
use App\Repository\Interfaces\ProductRepositoryInterface;
use App\Repository\Interfaces\RoleRepositoryInterface;
use App\Repository\Interfaces\SliderRepositoryInterface;
use App\Repository\Interfaces\UserInterestedCategoryRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use App\Repository\Repositories\BrandRepository;
use App\Repository\Repositories\CategoryRepository;
use App\Repository\Repositories\OrderRepository;
use App\Repository\Repositories\ProductRepository;
use App\Repository\Repositories\RoleRepository;
use App\Repository\Repositories\SliderRepository;
use App\Repository\Repositories\UserInterestedCategoryRepository;
use App\Repository\Repositories\UserRepository;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BrandRepositoryInterface::class,BrandRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class,CategoryRepository::class);
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
        $this->app->bind(OrderRepositoryInterface::class,OrderRepository::class);
        $this->app->bind(ProductRepositoryInterface::class,ProductRepository::class);
        $this->app->bind(RoleRepositoryInterface::class,RoleRepository::class);
        $this->app->bind(SliderRepositoryInterface::class,SliderRepository::class);
        $this->app->bind(UserInterestedCategoryRepositoryInterface::class,UserInterestedCategoryRepository::class);
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (env('APP_ENV') == 'production') {
            $url->forceScheme('https');
        }
    }
}
