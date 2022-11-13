<?php

namespace App\Http\Controllers\Admin;

use App\Model\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::orderBy('id', 'desc')->paginate(10);
        return view('site.admin.menu.all', compact('menus'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::where('parent_id', 0)->get();
        return view('site.admin.menu.create', compact('menus'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'link' => 'required',
            'parent_id' => 'required',
            'icon' => 'mimes:jpeg,png,bmp,jpg,gif,svg,webp|max:20480',
        ]);

        $menu = new Menu();
        $menu->title = $request->title;
        $menu->type = $request->type;
        $menu->link = $request->link;
        $menu->active = $request->active;
        $menu->parent_id = $request->parent_id;
        $menu->lang = $request->lang;

        $BASE_PATH = env('BASE_PATH');
        if ($request->hasFile('icon')) {
            $filename = $request->file('icon');
            $name = sha1(time() . $filename->getClientOriginalName());
            $extension = $filename->getClientOriginalExtension();
            $filename = "{$name}.{$extension}";
            $request->icon->move(base_path($BASE_PATH .'images/menu/'), $filename);
            $menu->icon = '/images/menu/' . $filename;
        }

        $menu->save();


        $locale = app()->getLocale();

        $cachemenus = Cache::get( "menus.$locale");
        if (isset($cachemenus)) {
            $menus = $cachemenus;
        } else {
            $menus = Menu::with('children')->where('active', 1)
                ->lang()
                ->where('parent_id', 0)->get();

            Cache::put("menus.$locale", $menus);
        }


        alert()->success(translate('Menu saved successfully.'), translate('save menu'))->confirmButton(translate('OK'))->autoclose('3000');

        return redirect()->route('menu.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $menus = Menu::where('parent_id', 0)->get();
        return view('site.admin.menu.edit', compact(['menu', 'menus']));
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
            'link' => 'required',
            'parent_id' => 'required',
            'icon' => 'mimes:jpeg,png,bmp,jpg,gif,svg,webp|max:20480',
        ]);


        $menu = Menu::findOrFail($id);

        $menu->title = $request->title;
        $menu->type = $request->type;
        $menu->link = $request->link;
        $menu->active = $request->active;
        $menu->parent_id = $request->parent_id;
        $menu->lang = $request->lang;

        $BASE_PATH = env('BASE_PATH');
        if ($request->hasFile('icon')) {
            $filename = $request->file('icon');
            $name = sha1(time() . $filename->getClientOriginalName());
            $extension = $filename->getClientOriginalExtension();
            $filename = "{$name}.{$extension}";
            $request->icon->move(base_path($BASE_PATH .'images/menu/'), $filename);
            $menu->icon = '/images/menu/' . $filename;
        }

        $menu->update();

        $locale = app()->getLocale();

        $cachemenus = Cache::get( "menus.$locale");
        if (isset($cachemenus)) {
            $menus = $cachemenus;
        } else {
            $menus = Menu::with('children')->where('active', 1)
                ->lang()
                ->where('parent_id', 0)->get();

            Cache::put("menus.$locale", $menus);
        }

        alert()->success(translate('Menu edited successfully'), translate('Edit menu'))->confirmButton(translate('OK'))->autoclose('3000');
        return redirect()->route('menu.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {

        $menu->delete();
        $locale = app()->getLocale();

        $cachemenus = Cache::get( "menus.$locale");
        if (isset($cachemenus)) {
            $menus = $cachemenus;
        } else {
            $menus = Menu::with('children')->where('active', 1)
                ->lang()
                ->where('parent_id', 0)->get();

            Cache::put("menus.$locale", $menus);
        }
        alert()->success(translate('The menu has been successfully deleted'), translate('delete menu'))->confirmButton(translate('OK'))->autoclose('3000');
        return back();
    }
}
