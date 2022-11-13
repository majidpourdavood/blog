<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Model\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $blogs = Blog::orderBy('id', 'desc')->paginate(100);
        return view('site.admin.blog.all', compact('blogs'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('type', 0)->get();
        return view('site.admin.blog.create', compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:blogs',
            'body' => 'required',
            'description' => 'required|string|max:165',
            'image' => 'mimes:jpeg,png,bmp,jpg,gif,svg,webp|max:20480',
        ]);

        $blogCode = randomNumber(9);
        if (in_array(trim($blogCode), Blog::all()->pluck('code')->toArray())) {
            $blogCode = randomNumber(9);
        }

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->slug = str_replace(' ', '-', $request->title);
        $blog->body = $request->body;
        $blog->description = $request->description;
        $blog->code = $blogCode;
        $blog->active = $request->active;
        $blog->tags = $request->tags;
        $blog->user_id = auth()->user()->id;
        $blog->category_id = $request->category_id;
        $blog->created_at = $request->created_at;
        $blog->lang = $request->lang;

        $blog->save();

        $array_images = $request->images;
        uploadFilesModel('store', $blog, $array_images);

        alert()->success( translate('Blog saved successfully') , translate('Save the blog'))
            ->confirmButton(translate('OK'))->autoclose('3000');

        return redirect()->route('blog.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $categories = Category::where('type', 0)->get();
        return view('site.admin.blog.edit', compact(['blog', 'categories']));

    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'description' => 'string|max:165',
            'image' => 'mimes:jpeg,png,bmp,jpg,gif,svg,webp|max:20480',
        ]);


        $blog = Blog::findOrFail($id);
        $blog->title = $request->title;
        $blog->slug = str_replace(' ', '-', $request->title);
        $blog->body = $request->body;
        $blog->description = $request->description;

        $blog->active = $request->active;
        $blog->tags = $request->tags;
        $blog->category_id = $request->category_id;
        $blog->created_at = $request->created_at;
        $blog->lang = $request->lang;
        $blog->update();


        $array_images = $request->images;
        uploadFilesModel('update', $blog, $array_images);

        alert()->success(translate('The blog was edited successfully'),
            translate('Edit blog'))->confirmButton(translate('OK'))->autoclose('3000');
        return redirect()->route('blog.index');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {

        $blog->delete();

        alert()->success(translate('The blog has been successfully deleted'),
            translate('Delete the blog'))->confirmButton(translate('OK'))->autoclose('3000');
        return back();
    }
}
