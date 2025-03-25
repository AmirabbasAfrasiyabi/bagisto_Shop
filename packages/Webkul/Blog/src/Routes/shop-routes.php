<?php

use Illuminate\Support\Facades\Route;
use Webkul\Blog\Http\Controllers\Admin\BlogController;
// use Webkul\Blog\Http\Controllers\Shop\PostController;

Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {
       /**
       * Blog routes.
       */
      Route::controller(BlogController::class)->prefix('blogs')->group(function () {
          Route::get('', 'index')->name('shop.blogs.index');

          // Here you can add your own routes related to the blog 
  });
});
