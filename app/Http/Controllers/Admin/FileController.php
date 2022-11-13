<?php

namespace App\Http\Controllers\Admin;

use App\Location;
use App\Model\Blog;
use App\Model\Course;
use App\Model\File;
use App\Model\Place;
use App\Model\Portfolio;
use App\Model\Product;
use App\Model\Service;
use App\Model\Slider;
use App\Model\Tour;
use App\Model\WayMigration;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->fileable_type == "App\\Model\\Blog") {
            $model = Blog::where('id', $request->fileable_id)->first();
         } else {
            $model = new Collection();
        }

//        return $request;
        return view('site.admin.files.create', compact(['model']));
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
            'title' => 'required|string',
            'fileable_id' => 'required',
            'fileable_type' => 'required',
        ]);

        $file = new File();
        $file->title = $request->title;
        $file->type = $request->type;
        $file->fileable_id = $request->fileable_id;
        $file->fileable_type = $request->fileable_type;
        $file->active = $request->active;
        $file->user_id = auth()->user()->id;

        $BASE_PATH = env('BASE_PATH');
        if($request->type == 9){
            $file->file = $request->file;
        }else{
            if ($request->hasFile('file')) {
                $filename = $request->file('file');
                $name = sha1(time() . $filename->getClientOriginalName());
                $extension = $filename->getClientOriginalExtension();
                $filename = "{$name}.{$extension}";
                $request->file->move(base_path($BASE_PATH .'file/'), $filename);
                $file->file = '/file/' . $filename;
            }
        }



        $file->save();

        alert()->success(translate('File saved successfully'), translate('Save the file'))
            ->confirmButton(translate('OK'))->autoclose('3000');

        return redirect()->route('createFile', [
            "fileable_id" => $file->fileable_id,
            "fileable_type" => $file->fileable_type,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $file = File::where('id', $id)->first();
        return view('site.admin.files.edit', compact('file'));

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
            'title' => 'required|string',
        ]);

        $file = File::findOrFail($id);
        $file->title = $request->title;
        $file->type = $request->type;
        $file->active = $request->active;

        $BASE_PATH = env('BASE_PATH');

        if($request->type == 9){
            $file->file = $request->file;
        }else{
            if ($request->hasFile('file')) {
                $filename = $request->file('file');
                $name = sha1(time() . $filename->getClientOriginalName());
                $extension = $filename->getClientOriginalExtension();
                $filename = "{$name}.{$extension}";
                $request->file->move(base_path($BASE_PATH .'file/'), $filename);
                $file->file = '/file/' . $filename;
            }
        }

        $file->update();

        alert()->success(translate('File edited successfully'), translate('File editing'))->confirmButton(translate('OK'))->autoclose('3000');

        return redirect()->route('createFile', [
            "fileable_id" => $file->fileable_id,
            "fileable_type" => $file->fileable_type,
        ]);


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = File::where('id', $id)->first();
        $file->delete();
        alert()->success(translate('File deleted successfully'), translate('Delete the file'))->confirmButton(translate('OK'))->autoclose('3000');
        return back();
    }
}
