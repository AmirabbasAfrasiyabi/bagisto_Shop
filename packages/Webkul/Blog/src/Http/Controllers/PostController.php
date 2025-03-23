<?php

namespace Webkul\Blog\Http\Controllers;

use Webkul\Blog\Http\Controllers\Admin\BlogController;
use Webkul\Blog\Repositories\PostRepository;

class PostController extends BlogController
{
    /**
     * PostRepository object
     *
     * @var \Webkul\Blog\Repositories\PostRepository
     */
    protected $postRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Blog\Repositories\PostRepository  $postRepository
     * @return void
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
}