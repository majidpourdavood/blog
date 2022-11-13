<?php

namespace App\Http\Controllers\Admin;

use App\Model\Blog;
use App\Model\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->itemable_type == "App\\Model\\Blog") {
            $model = Blog::where('id', $request->itemable_id)->first();
        } else {
            $model = new Collection();
        }

        return view('site.admin.items.create', compact(['model']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function sortableItem()
    {
        $position = $_POST['sort'];

        $i = 1;
        foreach ($position as $k => $v) {
            $users = Item::where('id', '=', $v)->update(array("sort" => $i));
            $i++;
        }
        return response(['status' => 'success', 'data' => $users]);

    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'active' => 'required',
            'itemable_id' => 'required',
            'itemable_type' => 'required',
        ]);

        $item = new Item();
        $item->title = $request->title;
        $item->active = $request->active;
        $item->itemable_id = $request->itemable_id;
        $item->itemable_type = $request->itemable_type;

        $item->type = $request->type;

        if (isset($request->description)) {
            $item->description = $request->description;
        } else {
            $item->description = $request->bodyAdmin;
        }

        $item->save();

        alert()->success(translate('Item saved successfully'), translate('Save item'))->confirmButton(translate('OK'))->autoclose('3000');

        return redirect()->route('createItem', [
            "itemable_id" => $item->itemable_id,
            "itemable_type" => $item->itemable_type,
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
        $item = Item::where('id', $id)->first();
        return view('site.admin.items.edit', compact('item'));

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
            'active' => 'required',
        ]);

        $item = Item::findOrFail($id);
        $item->title = $request->title;
        $item->active = $request->active;
        $item->type = $request->type;

        if (isset($request->description)) {
            $item->description = $request->description;
        } else {
            $item->description = $request->bodyAdmin;
        }

        $item->update();

        alert()->success(translate('Item edited successfully'), translate('Edit item'))->confirmButton(translate('OK'))->autoclose('3000');

        return redirect()->route('createItem', [
            "itemable_id" => $item->itemable_id,
            "itemable_type" => $item->itemable_type,
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
        $item = Item::where('id', $id)->first();
        $item->delete();
        alert()->success(translate('Item deleted successfully'), translate('Delete item'))->confirmButton(translate('OK'))->autoclose('3000');
        return back();
    }
}
