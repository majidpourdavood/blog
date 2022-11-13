<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\Model\Comment;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;


class AdminController extends Controller
{

    public function cacheClear()
    {

        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');

        alert()->success(translate('Cache cleared successfully.'), translate('Clear Cache'))
            ->confirmButton(translate('OK'))->autoclose(9000);
        return back();
    }


    public function index()
    {

        $users = User::all()->count();
        $comments = Comment::all()->count();
        $blogs = Blog::all()->count();
        return view('site.admin.dashboard', compact(['users', 'comments', 'blogs']));
    }


    public function notifications()
    {
        $notifications = auth()->user()->notifications()->paginate(7);
        auth()->user()->unreadNotifications->markAsRead();
        return view('site.admin.notification', compact(['notifications']));
    }


    public function uploadImageSubject()
    {

        $this->validate(request(), [
            'upload' => 'required|mimes:jpeg,png,bmp,jpg,gif,svg,webp|max:20480',
        ]);

        $year = Carbon::now()->year;
        $imagePath = "/upload/images/{$year}/";

        $BASE_PATH = env('BASE_PATH');

        $file = request()->file('upload');
        $filename = $file->getClientOriginalName();

        if (file_exists(base_path($BASE_PATH . $imagePath) . $filename)) {
            $filename = request()->file('upload');
            $name = sha1(time() . $filename->getClientOriginalName());
            $extension = $filename->getClientOriginalExtension();
            $filename = "{$name}.{$extension}";
        }
        $file->move(base_path($BASE_PATH . $imagePath), $filename);

        $response = [
            'uploaded' => 1,
            'fileName' => $filename,
            'url' => $imagePath . $filename,
        ];
        return response()->json($response);

    }


}
