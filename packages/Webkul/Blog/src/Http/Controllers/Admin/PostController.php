<?php

namespace Webkul\Blog\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Webkul\Blog\Repositories\PostRepository;

class PostController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * نمونه‌ای از کنترلر را ایجاد می‌کند.
     * 
     * @param  \Webkul\Blog\Repositories\PostRepository  $postRepository
     */
    public function __construct(protected PostRepository $postRepository)
    {
    }

    /**
     * نمایش لیست پست‌ها.
     * 
     * @return \Illuminate\View\View
     */
    public function index() 
    {
        $blogs = $this->postRepository->all();
        return view('blog::admin.index', compact('blogs'));
    }

    /**
     * نمایش فرم ایجاد پست جدید.
     * 
     * @return \Illuminate\View\View
     */
    public function create() 
    {
        return view('blog::admin.create');
    }

    /**
     * ذخیره پست جدید.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->postRepository->create($request->all());
        return redirect()->route('admin.blog.index')->with('success', 'پست با موفقیت اضافه شد');
    }

    /**
     * نمایش فرم ویرایش پست.
     * 
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $blog = $this->postRepository->find($id);
        return view('blog::admin.edit', compact('blog'));
    }

    /**
     * به‌روزرسانی پست موجود.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->postRepository->update($request->all(), $id);
        return redirect()->route('admin.blog.index')->with('success', 'پست با موفقیت ویرایش شد');
    }

    /**
     * حذف پست.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->postRepository->delete($id);
        return redirect()->route('admin.blog.index')->with('success', 'پست با موفقیت حذف شد');
    }
}
