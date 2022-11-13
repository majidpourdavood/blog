<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Location;
use App\Model\Blog;
use App\User;
use Carbon\Carbon;

class SitemapController extends Controller
{


    public function index()
    {
        $blog = Blog::where('active', '=', 1)->first();

        return response()->view('site.view.sitemap.index', [
            'blog' => $blog,
        ])->header('Content-Type', 'text/xml');
    }

    public function all()
    {
        return response()->view('site.view.sitemap.all')->header('Content-Type', 'text/xml');
    }


    public function blogs()
    {
        $blogs = Blog::where('active', '=', 1)->where('created_at', '<=', Carbon::now()->addHours(1))->orderBy('created_at', 'desc')->get();
        return response()->view('site.view.sitemap.blogs', [
            'blogs' => $blogs,
        ])->header('Content-Type', 'text/xml');
    }


}
