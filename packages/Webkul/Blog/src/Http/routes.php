<?php

namespace Webkul\Blog\Http;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function () {

    Route::prefix('blog')->group(function () {
        Route::get('/', 'Webkul\Blog\Http\Controllers\PostController@index');
        Route::get('/{slug}', 'Webkul\Blog\Http\Controllers\PostController@show');
    });

    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::prefix('blog')->group(function () {
            Route::get('/', 'Webkul\Blog\Http\Controllers\Admin\BlogController@index');
            Route::get('/create', 'Webkul\Blog\Http\Controllers\Admin\BlogController@create');
            Route::post('/store', 'Webkul\Blog\Http\Controllers\Admin\BlogController@store');
            Route::get('/edit/{id}', 'Webkul\Blog\Http\Controllers\Admin\BlogController@edit');
            Route::put('/update/{id}', 'Webkul\Blog\Http\Controllers\Admin\BlogController@update');
            Route::delete('/destroy/{id}', 'Webkul\Blog\Http\Controllers\Admin\BlogController@destroy');
        });
    });
});