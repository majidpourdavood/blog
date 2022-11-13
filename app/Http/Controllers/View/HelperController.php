<?php

namespace App\Http\Controllers\View;

use App\Category;
use App\Http\Controllers\Controller;
use App\Location;
use App\Model\File;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class HelperController extends Controller
{

    public function getLocationAjax($id)
    {
        $locations = Location::where('parent_id', $id)->orderBy('name', 'ASC')->get();

        if (!isset($locations)) {
            $locations = Location::where('parent_id', 0)
                ->orderBy('name', 'ASC')->get();
        }

        if (count($locations)) {
            $items = array();
            foreach ($locations as $key => $value) {
                $items[$key]['id'] = $value['id'];
                $items[$key]['name'] = $value['name'];
                $items[$key]['parent_id'] = $value['parent_id'];
                $items[$key]['children'] = Location::find($value['id']) && count(Location::find($value['id'])->children) > 0 ? "1" : "0";
            }

            return response()->json([
                    "locations" => $items,
                    "status" => "success",
                ]
            );
        } else {
            $locations = Location::where('parent_id', 0)->orderBy('name', 'ASC')->get();
            $items = array();
            foreach ($locations as $key => $value) {
                $items[$key]['id'] = $value['id'];
                $items[$key]['selected'] = Location::where('id', $id)->first() &&
                Location::where('id', $id)->first()->parent && Location::where('id', $id)->first()->parent->id == $value['id'] ? "selected" : "";
                $items[$key]['name'] = $value['name'];
                $items[$key]['parent_id'] = $value['parent_id'];
                $items[$key]['children'] = Location::find($value['id']) && count(Location::find($value['id'])->children) > 0 ? "1" : "0";
            }

            $childes = array();
            if (Location::where('id', $id)->first() && Location::where('id', $id)->first()->parent) {
                foreach (Location::where('id', $id)->first()->parent->children()->orderBy('name', 'ASC')->get() as $key => $value) {
                    $childes[$key]['id'] = $value['id'];
                    $childes[$key]['selected'] = Location::where('id', $id)->first()->id == $value['id'] ? "selected" : "";
                    $childes[$key]['name'] = $value['name'];
                    $childes[$key]['parent_id'] = $value['parent_id'];
                    $childes[$key]['children'] = count(Location::find($value['id'])->children) > 0 ? "1" : "0";
                }
            }
            return response()->json([
                    "childes" => $childes,
                    "locations" => $items,
                    "status" => "success",
                ]
            );

        }

    }

    public function getCategoryAjax($id)
    {
        $type = \request('type');

        if (isset($type)) {
            $categories = Category::where('parent_id', $id)
                ->lang()  ->where('type', $type)
              ->orderBy('title', 'ASC')->get();
        } else {
            $categories = Category::where('parent_id', $id)
                ->lang() ->orderBy('title', 'ASC')->get();
        }


        if (!isset($categories)) {
            $categories = Category::where('parent_id', 0)
                ->where('type', $type)
                ->lang() ->orderBy('title', 'ASC')->get();
        }


        if (count($categories)) {
            $items = array();
            foreach ($categories as $key => $value) {
                $items[$key]['id'] = $value['id'];
                $items[$key]['name'] = $value['title'];
                $items[$key]['parent_id'] = $value['parent_id'];
                $items[$key]['children'] = Category::find($value['id']) && count(Category::find($value['id'])->children) > 0 ? "1" : "0";
            }

            return response()->json([
                    "categories" => $items,
                    "status" => "success",
                ]
            );
        } else {

            if (isset($type)) {
                $categories = Category::where('parent_id', 0)
                    ->where('type', $type)
                    ->lang()->orderBy('title', 'ASC')->get();
            } else {
                $categories = Category::where('parent_id', 0)
                    ->lang()->orderBy('title', 'ASC')->get();
            }

            $items = array();
            foreach ($categories as $key => $value) {
                $items[$key]['id'] = $value['id'];
                $items[$key]['selected'] = Category::where('id', $id)->first() && Category::where('id', $id)->first()->parent && Category::where('id', $id)->first()->parent->id == $value['id'] ? "selected" : "";
                $items[$key]['name'] = $value['title'];
                $items[$key]['parent_id'] = $value['parent_id'];
                $items[$key]['children'] = Category::find($value['id']) && count(Category::find($value['id'])->children) > 0 ? "1" : "0";
            }


            $childes = array();
            if (Category::where('id', $id)->first() && Category::where('id', $id)->first()->parent) {
                foreach (Category::where('id', $id)->first()->parent->children()->orderBy('title', 'ASC')->get() as $key => $value) {
                    $childes[$key]['id'] = $value['id'];
                    $childes[$key]['selected'] = Category::where('id', $id)->first() && Category::where('id', $id)->first()->id == $value['id'] ? "selected" : "";
                    $childes[$key]['name'] = $value['title'];
                    $childes[$key]['parent_id'] = $value['parent_id'];
                    $childes[$key]['children'] = Category::find($value['id']) && count(Category::find($value['id'])->children) > 0 ? "1" : "0";
                }
            }

            return response()->json([
                    "childes" => $childes,
                    "categories" => $items,
                    "status" => "success",
                ]
            );

        }

    }

    public function getCategoryTree()
    {
        $type = \request('type');
        $category_id = \request('category_id');

        $collection = new Collection();
        $categories = Category::where('type', '=', $type)
            ->lang()
            ->get();

        foreach ($categories as $category) {
            $newstd = new \stdClass();
            $newstd->id = (string)$category->id;
            $newstd->text = (string)$category->title;
            $newstd->parent = $category->parent_id > 0 ? "$category->parent_id" : "#";

            if ($category_id == $category->id) {
                $state = new \stdClass();
                $state->opened = true;
                $state->selected = true;
                $newstd->state = $state;
            }
            $collection->push($newstd);
        }

        return response()->json($collection, 200);

    }

    public function uploadFileModel(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,png,bmp,jpg,gif,svg,webp|max:20480',

        ]);

        $BASE_PATH = env('BASE_PATH');


        if ($validator->fails()) {

            $response = [
                "title" => translate('upload'),
                "text" => $validator->errors()->first(),
                "icon" => "error",
                "button" => translate('OK'),
                "status" => "notAccess",
            ];

            return response()->json(
                $response
                , 200);

        } else {
            $user = auth()->user();

            $file = $user->files()->where('type', 1)->where('active', 1)->first();
            if (isset($file)) {
                if ($request->hasFile('file')) {
                    $filename = $request->file('file');
                    $name = sha1(time() . $filename->getClientOriginalName());
                    $extension = $filename->getClientOriginalExtension();
                    $filename = "{$name}.{$extension}";
                    $request->file->move(base_path($BASE_PATH . 'file/'), $filename);
                    $file->file = '/file/' . $filename;
                }


                $file->update();
            } else {
                $file = new File();
                $file->title = translate('Upload the background image of the company page');
                $file->type = 1;
                $file->fileable_id = $user->id;
                $file->fileable_type = get_class($user);
                $file->active = 1;
                $file->user_id = $user->id;

                if ($request->hasFile('file')) {
                    $filename = $request->file('file');
                    $name = sha1(time() . $filename->getClientOriginalName());
                    $extension = $filename->getClientOriginalExtension();
                    $filename = "{$name}.{$extension}";
                    $request->file->move(base_path($BASE_PATH .'file/'), $filename);
                    $file->file = '/file/' . $filename;
                }

                $file->save();
            }

            $url = $file->file;

            $response = [
                "title" => translate('upload'),
                "text" => translate('Uploaded'),
                "icon" => "success",
                "button" => translate('OK'),
                "status" => "success",
                'url' => $url,
                'filename' => $filename,
            ];
            return response()->json(
                $response
                , 200);

        }

    }

    public function deleteFiles($id)
    {
        $file = File::where('id', $id)->first();
        $file->delete();
        $response = [
            "title" => translate('Delete'),
            "text" => translate('Deleted.'),
            "icon" => "success",
            "button" => translate('OK'),
            "status" => "success",
            'file' => $file,
        ];
        return response()->json(
            $response
            , 200);

    }

    public function uploadFiles(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,png,bmp,jpg,gif,svg,webp|max:20480',
        ]);

        $BASE_PATH = env('BASE_PATH');

        if ($validator->fails()) {

            $response = [
                "title" => translate('upload'),
                "text" => $validator->errors()->first(),
                "icon" => "error",
                "button" => translate('OK'),
                "status" => "notAccess",
            ];

            return response()->json(
                $response
                , 200);

        } else {

            $file_main = File::where('type', 0)
                ->where('fileable_id', $request->fileable_id)
                ->where('fileable_type', $request->fileable_type)
                ->first();

            if ($file_main) {
                $type = 2;
            } else {
                $type = 0;
            }


            $user = auth()->user();
            $file = new File();
            $file->title = translate('Upload image gallery');
            $file->type = $type;
            $file->fileable_id = $request->fileable_id;
            $file->fileable_type = $request->fileable_type;
            $file->active = 1;
            $file->user_id = $user->id;

            if ($request->hasFile('file')) {
                $filename = $request->file('file');
                $name = sha1(time() . $filename->getClientOriginalName());
                $extension = $filename->getClientOriginalExtension();
                $filename = "{$name}.{$extension}";
                $request->file->move(base_path($BASE_PATH .'file/'), $filename);
                $file->file = '/file/' . $filename;
            }


            $file->save();


            $url = $file->file;

            $response = [
                "title" => translate('upload'),
                "text" => translate('Uploaded'),
                "icon" => "success",
                "button" => translate('OK'),
                "status" => "success",
                'file' => $file,
//                'filename' => $filename,
            ];
            return response()->json(
                $response
                , 200);

        }


    }

    public function uploadFileAll(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,png,bmp,jpg,gif,svg,webp|max:20480',
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
                $request->file('file')->move(base_path($BASE_PATH . 'file/'), $filename);
            }

            $url = '/file/' . $filename;
            $response = [
                'msg' => translate('The file has been uploaded'),
                'filename' => $url,
                'status' => 200,
            ];
            return response()->json($response);
        }
    }

}
