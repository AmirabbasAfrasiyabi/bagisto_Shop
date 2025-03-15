<?php

namespace Webkul\Blog\Http\Controllers\Shop;

use Webkul\Blog\Http\Controllers\Controller;
use Webkul\Blog\Repositories\PostRepository;

class PostController extends Controller
{
    public function __construct(protected PostRepository $postRepository)
    {
    }

    /**
     * Index.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $blogs = $this->postRepository->with(['author'])->all();

        return view('blog::shop.index', compact('blogs'));
    }

    /**
     * Blog details.
     * 
     * @return \Illuminate\View\View
     */
    public function view(int $id) 
{
   
    return view('blog::shop.view', compact('blog'));
}

}
