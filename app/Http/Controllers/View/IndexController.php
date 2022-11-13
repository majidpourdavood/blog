<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Model\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Session;

class IndexController extends Controller
{

    public function contactUs()
    {
        return view('site.view.contactUs');
    }

    public function aboutUs()
    {

        return view('site.view.aboutUs');
    }


    public function setLanguage(Request $request)
    {


        $locale = $request->local;
        App::setLocale($request->local);
        session()->put('locale', $locale);
        return redirect()->back();
    }

    public function filter(Request $request)
    {
        $locations = request('location_id');
        $categories = request('category_id');
        return view('site.view.data.dataFilter', compact(['locations', 'categories']));
    }

    public function index(Request $request)
    {
//dd(translate('Dilgun_magazine'));
        if (\request()->ajax() &&
            $request->has('type_search') &&
            request('type_search') == "filter") {

            return view('site.view.data.dataFilter');
        }
        $locale = app()->getLocale();

        $blogs = Blog::
        where('active', '=', 1)
            ->lang()
            ->orderBy('created_at', 'desc')
            ->filterBlog()->paginate(6);

        if (\request()->ajax()) {
            return view('site.view.data.dataBlogs', [
                'blogs' => $blogs,
            ])->render();
        }
        return view('site.view.blog.blogs', compact([
            'blogs',
        ]));

    }


    public function blogs(Request $request)
    {

        if (\request()->ajax() &&
            $request->has('type_search') &&
            request('type_search') == "filter") {

            return view('site.view.data.dataFilter');
        }

        $blogs = Blog::
        where('active', '=', 1)
            ->orderBy('created_at', 'desc')
            ->filterBlog()->paginate(6);

        if (\request()->ajax()) {
            return view('site.view.data.dataBlogs', [
                'blogs' => $blogs,
            ])->render();
        }
        return view('site.view.blog.blogs', compact([
            'blogs',
        ]));

    }

    public function blog($slug)
    {
        $blog = Blog::where('slug', '=', $slug)->where('active', '=', 1)->first();

        if (!$blog) {
            abort(404);
        }

        if ($blog) {
            $blog->increment('viewCount');
            $comments = $blog->comments()->where('approved', 1)->where('parent_id', 0)->latest()->with(['comments' => function ($query) {
                $query->where('approved', 1)->latest();
            }])->get();

            $blogRelateds = Blog::where('active', '=', 1)->where('category_id', '=', $blog->category_id)->where('id', '!=', $blog->id)->orderBy('created_at', 'desc')->limit(5)->get();

            return view('site.view.blog.single', compact(['blog', 'comments', 'blogRelateds']));

        } else {
            return redirect('/');
        }
    }

    public function blogLink($id)
    {
        $blog = Blog::where('id', '=', $id)->where('active', '=', 1)->first();

        if (!$blog) {
            abort(404);
        }

        if ($blog) {
            return redirect()->route('blog', $blog->slug);
        } else {
            return redirect('/');
        }
    }


}
