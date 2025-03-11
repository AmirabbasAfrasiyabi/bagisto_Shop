<?php

namespace Webkul\Blog\Http\Controllers;

use Webkul\Blog\Repositories\PostRepository;

class PostController
{
    /**
     * Repository مربوط به پست‌ها
     */
    public function __construct(protected PostRepository $postRepository) {}

    /**
     * نمایش لیست پست‌های منتشرشده
     */
    public function index()
    {
        $posts = $this->postRepository->getPublishedPosts();

        return response()->json($posts);
    }
}
