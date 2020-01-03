<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        $this->app->bind('users', \App\Repositories\UsersRepository::class);
        $this->app->bind('posts', \App\Repositories\PostsRepository::class);
        // $this->app->when(\App\Http\Controllers\Api\v1\PostsController::class)
        //           ->needs(\App\Repositories\Repository::class)
        //           ->give(\App\Repositories\PostsRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\Post::observe(\App\Observers\PostObserver::class);
    }
}
