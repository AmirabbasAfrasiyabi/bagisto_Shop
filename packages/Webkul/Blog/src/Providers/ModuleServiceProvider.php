<?php

namespace Webkul\Blog\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    /**
     * مدل‌هایی که در این ماژول ثبت می‌شوند.
     */
    protected $models = [
        \Webkul\Blog\Models\Post::class,
    ];

    /**
     * رجیستر کردن Repository در Container لاراول.
     */
    public function register()
    {
        $this->app->bind(\Webkul\Blog\Repositories\PostRepository::class);
    }
}
