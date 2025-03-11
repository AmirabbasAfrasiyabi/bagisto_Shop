<?php

use Illuminate\Support\Facades\Route;
use Webkul\Blog\Http\Controllers\Shop\BlogController;

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency'], 'prefix' => 'blog'], function () {
    Route::get('', [BlogController::class, 'index'])->name('shop.blog.index');
});