<?php

namespace Webkul\Blog\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Webkul\Blog\Repositories\PostRepository;
use Webkul\Admin\Http\Controllers\Controller;

class BlogController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $posts = $this->postRepository->all();
        
        return view('blog::admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        return view('blog::admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);
        
        $this->postRepository->create($request->all());
        
        session()->flash('success', 'Post created successfully.');
        
        return redirect()->route('admin.blog.posts.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit($id): View|Factory
    {
        $post = $this->postRepository->findOrFail($id);
        
        return view('blog::admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);
        
        $this->postRepository->update($request->all(), $id);
        
        session()->flash('success', 'Post updated successfully.');
        
        return redirect()->route('admin.blog.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $this->postRepository->delete($id);
        
        session()->flash('success', 'Post deleted successfully.');
        
        return redirect()->route('admin.blog.posts.index');
    }
}