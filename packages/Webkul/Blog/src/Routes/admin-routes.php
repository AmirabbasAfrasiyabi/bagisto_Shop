<?php

use Illuminate\Support\Facades\Route;
use Webkul\Blog\Http\Controllers\Admin\BlogController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/blog'], function () {
    Route::controller(BlogController::class)->group(function () {
        Route::get('', 'index')->name('admin.blog.index');
    });
});