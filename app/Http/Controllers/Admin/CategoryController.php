<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->paginate(100);
        return view('site.admin.category.all', compact('categories'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id', 0)->get();
        return view('site.admin.category.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'parent_id' => 'required',
            'image' => 'mimes:jpeg,png,bmp,jpg,gif,svg,webp|max:20480',
        ]);

        $category = new Category();
        $category->title = $request->title;
        $category->slug = str_replace(' ', '-', $request->title);
        $category->type = $request->type;
        $category->description = $request->description;
        $category->body = $request->body;
        $category->active = $request->active;
        $category->parent_id = $request->parent_id;
        $category->lang = $request->lang;

        $BASE_PATH = env('BASE_PATH');

        if ($request->hasFile('image')) {
            $filename = $request->file('image');
            $name = sha1(time() . $filename->getClientOriginalName());
            $extension = $filename->getClientOriginalExtension();
            $filename = "{$name}.{$extension}";
            $request->image->move(base_path($BASE_PATH . 'images/category/'), $filename);
            $category->image = '/images/category/' . $filename;
        }

        $category->save();
        alert()->success(translate('Category saved successfully.'),
            translate('Store Category'))->confirmButton(translate('OK'))->autoclose('3000');

        return redirect()->route('category.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::where('parent_id', 0)->get();
        return view('site.admin.category.edit', compact(['category', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'parent_id' => 'required',
            'image' => 'mimes:jpeg,png,bmp,jpg,gif,svg,webp|max:20480',
        ]);


        $category = Category::findOrFail($id);

        $category->title = $request->title;
        $category->slug = str_replace(' ', '-', $request->title);
        $category->type = $request->type;
        $category->description = $request->description;
        $category->body = $request->body;
        $category->active = $request->active;
        $category->parent_id = $request->parent_id;
        $category->lang = $request->lang;

        $BASE_PATH = env('BASE_PATH');
        if ($request->hasFile('image')) {
            $filename = $request->file('image');
            $name = sha1(time() . $filename->getClientOriginalName());
            $extension = $filename->getClientOriginalExtension();
            $filename = "{$name}.{$extension}";
            $request->image->move(base_path($BASE_PATH . 'images/category/'), $filename);
            $category->image = '/images/category/' . $filename;
        }

        $category->update();
        alert()->success(translate('Category edited successfully'), translate('Edit category'))->confirmButton(translate('OK'))->autoclose('3000');
        return redirect()->route('category.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {

        $category->delete();
        alert()->success(translate('The category was successfully deleted'), translate('Remove category'))->confirmButton(translate('OK'))->autoclose('3000');
        return back();
    }
}
