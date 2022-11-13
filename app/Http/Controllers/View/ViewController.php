<?php

namespace App\Http\Controllers\View;

use App\Category;
use App\Http\Controllers\Controller;
use App\Location;
use App\Model\Blog;
use App\Model\Comment;
use App\Model\Like;
use App\Notifications\NotificationSendAll;
use App\Rating;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class ViewController extends Controller
{


    public function likeComment(Request $request)
    {

        $userIp = get_client_ip();
        $agent = \Request::header('User-Agent');

        $likeUserExist = Like::where('ip', '=', $userIp)
            ->where('agent', '=', $agent)
            ->where('likeable_id', '=', $request->likeable_id)
            ->where('likeable_type', '=', $request->likeable_type)->first();

        if (isset($likeUserExist)) {
            $likeUserExist->like = 1;
            $likeUserExist->update();
            return response()->json([
                'data' => translate('Your vote has been edited successfully.'),
                'likeComment' => $likeUserExist,
                'count' => count(Comment::findOrFail($likeUserExist->likeable_id)->likes()->where('like', '=', 1)->get()),
                'countdis' => count(Comment::findOrFail($likeUserExist->likeable_id)->likes()->where('like', '=', 0)->get()),

            ]);
        } else {
            $likeUser = new Like();
            $likeUser->like = 1;
            $likeUser->ip = $userIp;
            $likeUser->agent = $agent;
            $likeUser->likeable_id = $request->likeable_id;
            $likeUser->likeable_type = $request->likeable_type;
            $likeUser->save();
            return response()->json([
                'data' => translate('Your vote was successfully registered'),
                'likeComment' => $likeUser,
                'count' => count(Comment::findOrFail($likeUser->likeable_id)->likes()->where('like', '=', 1)->get()),
                'countdis' => count(Comment::findOrFail($likeUser->likeable_id)->likes()->where('like', '=', 0)->get()),
            ]);
        }


    }

    public function disLikeComment(Request $request)
    {

        $userIp = get_client_ip();
        $agent = \Request::header('User-Agent');

        $likeUserExist = Like::where('ip', '=', $userIp)
            ->where('agent', '=', $agent)
            ->where('likeable_id', '=', $request->likeable_id)
            ->where('likeable_type', '=', $request->likeable_type)->first();


        if (isset($likeUserExist)) {
            $likeUserExist->like = 0;
            $likeUserExist->update();
            return response()->json([
                'data' => translate('Your vote has been edited successfully.'),
                'disLikeComment' => $likeUserExist,
                'count' => count(Comment::findOrFail($likeUserExist->likeable_id)->likes()->where('like', '=', 1)->get()),
                'countdis' => count(Comment::findOrFail($likeUserExist->likeable_id)->likes()->where('like', '=', 0)->get()),

            ]);
        } else {
            $likeUser = new Like();
            $likeUser->like = 0;
            $likeUser->ip = $userIp;
            $likeUser->agent = $agent;
            $likeUser->likeable_id = $request->likeable_id;
            $likeUser->likeable_type = $request->likeable_type;
            $likeUser->save();
            return response()->json([
                'data' => translate('Your vote was successfully registered'),
                'disLikeComment' => $likeUser,
                'count' => count(Comment::findOrFail($likeUser->likeable_id)->likes()->where('like', '=', 1)->get()),
                'countdis' => count(Comment::findOrFail($likeUser->likeable_id)->likes()->where('like', '=', 0)->get()),

            ]);
        }


    }

    public function loginComment()
    {
        \request()->session()->put('url.intended', url()->previous());
        return redirect()->route('login');
    }

    public function registerComment()
    {
        \request()->session()->put('url.intended', url()->previous());
        return redirect()->route('register');
    }


    public function ratings(Request $request)
    {
        $rating = Rating::where('ip', '=', \request()->ip())
            ->where('ratingable_id', '=', $request->ratingable_id)
            ->where('ratingable_type', '=', $request->ratingable_type)->first();

        if ($rating) {
            $rating->rating = $request->rating;
            $rating->update();
            return response()->json([
                "status" => "update",
                'data' => translate('Your vote has been edited successfully.'),
            ], 200);
        } else {
            $rating = new Rating();
            $rating->rating = $request->rating;
            $rating->ip = request()->ip();
            $rating->ratingable_id = $request->ratingable_id;
            $rating->ratingable_type = $request->ratingable_type;
            $rating->save();
            return response()->json([
                "status" => "create",
                'data' => translate('Your vote was successfully registered'),
            ], 201);
        }


    }

    public function imageUploadView()
    {

        $this->validate(request(), [
            'upload' => 'required|mimes:jpeg,png,bmp,jpg,gif,svg,webp|max:20480',
        ]);

        $year = Carbon::now()->year;
        $imagePath = "/upload/images/{$year}/";

        $file = request()->file('upload');
        $filename = $file->getClientOriginalName();

        $BASE_PATH = env('BASE_PATH');
        if (file_exists(base_path($BASE_PATH  . $imagePath) . $filename)) {
            $filename = request()->file('upload');
            $name = sha1(time() . $filename->getClientOriginalName());
            $extension = $filename->getClientOriginalExtension();
            $filename = "{$name}.{$extension}";
        }

        $file->move(base_path($BASE_PATH . $imagePath), $filename);
        $url = $imagePath . $filename;

        $response = [
            'uploaded' => 1,
            'fileName' => $filename,
            'url' => $imagePath . $filename,
        ];
        return response()->json($response);


    }

    public function getLocation($id)
    {
        $cities = Location::where('parent_id', '=', $id)
            ->pluck("name", "id")->all();
        return json_encode($cities);
    }

    public function getCity($id)
    {
        $cities = Location::where('parent_id', '=', $id)->get();
        $selected_locations = json_decode(request('location'));
        $selected_locations = (array)$selected_locations;
        return view('site.view.data.dataCity', compact(['cities', 'selected_locations']));

    }

    public function getSubCategory($id)
    {
        $subCategories = Category::where('parent_id', '=', $id)->get();
        $selected_categories = json_decode(request('category'));
        $selected_categories = (array)$selected_categories;
        return view('site.view.data.dataSubCategory', compact(['subCategories', 'selected_categories']));

    }

    public function getCategory($id)
    {
        $type = \request('type');
        $cities = Category::where('parent_id', '=', $id)
            ->where('type', '=', $type)
            ->pluck("title", "id")->all();
        return json_encode($cities);
    }

    public function filter(Request $request)
    {
        $locations = request('location_id');
        $categories = request('category_id');
        return view('site.view.data.dataFilter', compact(['locations', 'categories']));
    }


    public function uploadFile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:png|max:20480',

        ]);

        $BASE_PATH = env('BASE_PATH');

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => 400,
                    "error" => $validator->errors()
                ]
            );
        } else {
            if ($request->hasFile('file')) {
                $filename = $request->file('file');
                $name = sha1(time() . $filename->getClientOriginalName());
                $extension = $filename->getClientOriginalExtension();
                $filename = "{$name}.{$extension}";
                $request->file('file')->move(base_path($BASE_PATH .'logo/'), $filename);
            }
            $response = [
                'msg' => translate('The file has been uploaded'),
                'filename' => $filename,
                'status' => 200,
            ];
            return response()->json($response);
        }
    }


    public function uploadImageUser(Request $request)
    {


        if (isset($_POST["image"])) {
            $data = $_POST["image"];

            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $imageName = time() . '.png';

            file_put_contents('userImage/' . $imageName, $data);
            $user = User::findOrFail(auth()->user()->id);
            $user->image = '/userImage/' . $imageName;
            $user->update();


            $response = [
                'msg' => translate('Image uploaded'),
                'filename' => $user->image
            ];
            return response()->json($response);
        }

    }




    public function loginIntended()
    {
        \request()->session()->put('url.intended', url()->previous());
        return redirect()->route('login');
    }

    public function registerIntended()
    {
        \request()->session()->put('url.intended', url()->previous());
        return redirect()->route('register');
    }



    public function comments(Request $request)
    {
        $this->validate($request, [
            'parent_id' => 'required',
            'comment' => 'required',
            'commentable_id' => 'required',
            'commentable_type' => 'required',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);
        $codeNumber = randomNumber(9);
        if (in_array(trim($codeNumber), Comment::all()->pluck('codeNumber')->toArray())) {
            $codeNumber = randomNumber(9);
        }
        $comment = new Comment();
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->comment;
        $comment->codeNumber = $codeNumber;
        $comment->name = isset($request->name) ? $request->name : translate('Unknown');
        $comment->email = $request->email;
        $comment->commentable_id = $request->commentable_id;
        $comment->commentable_type = $request->commentable_type;
        $comment->save();

        $message = ' ' . translate('A user named') . ' ' . $request->name . ' ' .translate('Posted a comment.');
        $link_text = 'نمایش پیام';
        $link = route('commentAll');
        $className = 'btn btn-success';
        $userSender = $comment->name ? $comment->name : translate('guest user');
        $users = User::whereHas(
            'roles', function ($q) {
            $q->where('slug', 'admin');
        })->where('active', '=', 1)->get();
        \Notification::send($users, (new NotificationSendAll($message, $link, $link_text, $className, $userSender)));


        alert()->success(translate('Your comment has been registered successfully'), translate('Send a comment'))
            ->confirmButton(translate('OK'))->autoclose(10000);
        return back();
    }

    public function getFile($filename)
    {
        $path = storage_path('app/public/resume/' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
