<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Routing\ResponseFactory;
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

        ResponseFactory::macro('success', function($message, $data = null) {
            return response()->json([
                'status' => 1,
                'message' => $message,
                'data' => $data,
            ]);
        });

        ResponseFactory::macro('error', function($message, $data, $httpCode = 500) {
            return response()->json([
                'status' => 0,
                'message' => $message,
                'data' => $data,
            ], $httpCode);
        });
    }
}
