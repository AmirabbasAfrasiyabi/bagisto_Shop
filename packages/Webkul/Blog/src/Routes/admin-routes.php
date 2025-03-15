<?php

use Illuminate\Support\Facades\Route;
use Webkul\Blog\Http\Controllers\Admin\BlogController;

  Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {
      /**
       * Blog routes.
       */
      Route::controller(BlogController::class)->prefix('blogs')->group(function () {
          Route::get('', 'index')->name('admin.blogs.index');

          // Here you can add your own routes related to the blog 
      });
  });
