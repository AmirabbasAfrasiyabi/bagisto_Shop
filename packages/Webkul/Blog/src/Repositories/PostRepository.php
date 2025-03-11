<?php

namespace Webkul\Blog\Repositories;

use Webkul\Core\Eloquent\Repository;

class PostRepository extends Repository
{
    /**
     * مشخص کردن مدل مرتبط با Repository.
     */
    public function model()
    {
        return 'Webkul\Blog\Models\Post';
    }

    /**
     * دریافت همه پست‌های منتشرشده.
     */
    public function getPublishedPosts()
    {
        return $this->model->where('is_published', true)->get();
    }
}
