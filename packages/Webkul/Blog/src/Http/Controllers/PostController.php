<?php

namespace Webkul\Blog\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Webkul\Blog\Http\Controllers\Admin\BlogController;
use Webkul\Blog\Repositories\PostRepository;

class PostController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
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