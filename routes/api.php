<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'namespace' => 'Api\v1\Dashboard',
        'prefix' => 'v1/dashboard',
    ],
    function() {
        Auth::routes();
        Route::group(['middleware' => ['auth:api', 'is_author']], function() {
            Route::get('/stats', 'StatsController@index');
            Route::get('/profile', 'ProfileController@index');
            Route::put('/profile', 'ProfileController@update');
            Route::resource('categories', 'CategoriesController');
            Route::resource('pages', 'PagesController')->middleware('is_admin');

            Route::group(['prefix' => 'posts'], function() {
                Route::get('/', 'PostsController@index');
                Route::post('/', 'PostsController@store');
                Route::post('/save-draft', 'PostsController@saveDraft');
                Route::get('/get-draft', 'PostsController@getDraft');
                Route::get('/published', 'PostsController@published');
                Route::get('/{post}', 'PostsController@show');
                Route::put('/{post}', 'PostsController@update');
                Route::delete('/{post}', 'PostsController@destroy');
                Route::delete('/{post}/comments/{comment}', 'CommentsController@destroy');

                Route::post('/{post}/add-to-featured', 'FeaturedPostsController@add')->middleware('is_admin');
                Route::post('/{post}/remove-from-featured', 'FeaturedPostsController@remove')->middleware('is_admin');
            });

            // Route::post('/upload-image', 'PhotoUploadController@upload');
            Route::resource('/comments', 'CommentsController')->middleware('is_admin');
            Route::resource('/series', 'SeriesController')->middleware('is_admin');
            Route::resource('/users', 'UsersController')->middleware('is_admin');

            Route::group(['prefix' => 'widgets', 'namespace' => '\App\Widgets'], function() {
                Route::resource('/group-posts', 'GroupPosts\GroupPosts')->middleware('is_admin');
            });
        });
    }
);

Route::group(['namespace' => 'Api\v1\Front', 'prefix' => 'v1'], function() {
    Auth::routes();
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('/profile', 'ProfileController@index');
        Route::put('/profile', 'ProfileController@update');
    });

    Route::get('/search', 'SearchController@search');
    Route::post('/contact', 'ContactController@submit');

    Route::group(['prefix' => 'posts'], function() {
        Route::get('/', 'PostsController@index');
        Route::get('/home', 'PostsController@homePosts');
        Route::get('/featured-posts', 'PostsController@featured');
        Route::get('/get-by-path/{path}', 'PostsController@getByPath');
        Route::get('/{post}', 'PostsController@show');
        Route::get('/preview/{post}', 'PostsController@preview');
        Route::get('/{post_id}/comments', 'CommentsController@index');
        Route::get('/{post}/related', 'PostsController@relatedPosts');
        Route::post('/{post}/comments', 'CommentsController@store');
    });
    Route::get('/comments/latest', 'CommentsController@latest');

    Route::group(['prefix' => 'categories'], function() {
        Route::get('/', 'CategoriesController@index');
        Route::get('/in-home', 'CategoriesController@inHomePage');
        Route::get('/{category}/', 'CategoriesController@single');
    });

    Route::get('/tags/{tag}', 'TagsController@index');
    Route::get('/users', 'UsersController@show')->middleware('cors');
    Route::get('/series/{id}', 'SeriesController@show');

    // Route::group(['middleware' => 'auth:api'], function() {
    //     Route::get('/profile', 'ProfileController@show');
    //     Route::put('/profile', 'ProfileController@update');
    // });

    Route::group(['prefix' => 'widgets', 'namespace' => '\App\Widgets'], function() {
        Route::get('/group-posts', 'GroupPosts\GroupPosts@posts');
    });

});
