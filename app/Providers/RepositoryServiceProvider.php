<?php

namespace App\Providers;

use App\Facades\ShopCatRepository;
use App\Facades\ShopRepository;
use App\Facades\ShopStoreRepository;
use App\Repositories\UserRepository;
use App\Repositories\MenuRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ActionRepository;
use App\Repositories\PermissionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // 合并自定义配置文件
        $configuration = realpath(__DIR__ . '/../../config/repository.php');
        $this->mergeConfigFrom($configuration, 'repository');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMenuRepository();
        $this->registerUserRepository();
        $this->registerRoleRepository();
        $this->registerActionRepository();
        $this->registerPermissionRepository();
        $this->registerShopRepository();
        $this->registerShopCatRepository();
        $this->registerShopStoreRepository();
    }

    /**
     * Register the Menu Repository
     *
     * @return mixed
     */
    public function registerMenuRepository()
    {
        $this->app->singleton('menurepository', function ($app) {
            $model = config('repository.models.menu');
            $menu = new $model();
            $validator = $app['validator'];

            return new MenuRepository($menu, $validator);
        });
    }

    public function registerUserRepository()
    {
        $this->app->singleton('userrepository', function ($app) {
            $model = config('repository.models.user');
            $user = new $model();
            $validator = $app['validator'];

            return new UserRepository($user, $validator);
        });
    }

    public function registerRoleRepository()
    {
        $this->app->singleton('rolerepository', function ($app) {
            $model = config('repository.models.role');
            $role = new $model();
            $validator = $app['validator'];

            return new RoleRepository($role, $validator);
        });
    }

    public function registerActionRepository()
    {
        $this->app->singleton('actionrepository', function ($app) {
            $model = config('repository.models.action');
            $action = new $model();
            $validator = $app['validator'];

            return new ActionRepository($action, $validator);
        });
    }

    public function registerPermissionRepository()
    {
        $this->app->singleton('permissionrepository', function ($app) {
            $model = config('repository.models.permission');
            $permission = new $model();
            $validator = $app['validator'];

            return new PermissionRepository($permission, $validator);
        });
    }

    public function registerShopRepository()
    {
        $this->app->singleton('shoprepository', function ($app) {
            $model = config('repository.models.shop');
            $shop = new $model();
            $validator = $app['validator'];

            return new ShopRepository($shop, $validator);
        });
    }

    public function registerShopCatRepository()
    {
        $this->app->singleton('shopcatrepository', function ($app) {
            $model = config('repository.models.shopcat');
            $shop = new $model();
            $validator = $app['validator'];

            return new ShopCatRepository($shop, $validator);
        });
    }

    public function registerShopStoreRepository()
    {
        $this->app->singleton('shopstorerepository', function ($app) {
            $model = config('repository.models.shopstore');
            $shop = new $model();
            $validator = $app['validator'];

            return new ShopStoreRepository($shop, $validator);
        });
    }
}
