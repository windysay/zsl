<?php

namespace App\Providers;

use App\Repositories\ArticleCatRepository;
use App\Repositories\BusinessCircleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\GoodsRepository;
use App\Repositories\ShopRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserProfileRepository;
use App\Repositories\MenuRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ActionRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\WeiboRepository;
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
        $this->registerArticleCatRepository();
        $this->registerArticleRepository();
        $this->registerUserProfileRepository();
        $this->registerGoodsRepository();
        $this->registerWeiboRepository();
        $this->registerBusinessCircleRepository();
        $this->registerCommentRepository();
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

    public function registerArticleCatRepository()
    {
        $this->app->singleton('articlecatrepository', function ($app) {
            $model = config('repository.models.articlecat');
            $cat = new $model();
            $validator = $app['validator'];

            return new ArticleCatRepository($cat, $validator);
        });
    }

    public function registerArticleRepository()
    {
        $this->app->singleton('articlerepository', function ($app) {
            $model = config('repository.models.article');
            $article = new $model();
            $validator = $app['validator'];

            return new ArticleCatRepository($article, $validator);
        });
    }

    public function registerUserProfileRepository()
    {
        $this->app->singleton('userprofilerepository', function ($app) {
            $model = config('repository.models.user-profile');
            $permission = new $model();
            $validator = $app['validator'];

            return new UserProfileRepository($permission, $validator);

        });
    }

    public function registerGoodsRepository()
    {
        $this->app->singleton('goodsrepository', function ($app) {
            $model = config('repository.models.goods');
            $permission = new $model();
            $validator = $app['validator'];

            return new GoodsRepository($permission, $validator);

        });
    }

    public function registerWeiboRepository()
    {
        $this->app->singleton('weiborepository', function ($app) {
            $model = config('repository.models.weibo');
            $permission = new $model();
            $validator = $app['validator'];

            return new WeiboRepository($permission, $validator);

        });
    }

    public function registerBusinessCircleRepository()
    {
        $this->app->singleton('businesscirclerepository', function ($app) {
            $model = config('repository.models.business-circle');
            $permission = new $model();
            $validator = $app['validator'];

            return new BusinessCircleRepository($permission, $validator);

        });
    }

    public function registerCommentRepository()
    {
        $this->app->singleton('commentrepository', function ($app) {
            $model = config('repository.models.comment');
            $permission = new $model();
            $validator = $app['validator'];

            return new CommentRepository($permission, $validator);

        });
    }

}
