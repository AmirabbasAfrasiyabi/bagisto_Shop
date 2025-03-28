<?php

namespace Webkul\Blog\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webkul\Blog\Repositories\PostRepository;

class BlogController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

      public function __construct(protected PostRepository $postRepository)
      {
      }


      public function index()
      {
          $blogs = $this->postRepository->with(['author'])->all();

          return view('blog::shop.index', compact('blogs'));
      }
}
