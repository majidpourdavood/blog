<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routeCollection = Route::getRoutes();

        $coolec = new Collection();
        foreach ($routeCollection as $value) {
            $new = new \stdClass();
            $new->url = $value->uri;
            $new->method = $value->methods;
            $new->as = $value->action['as'];

            if(strpos($value->uri, 'admin') !== false){
                $coolec->push($new);
            }

        }
        foreach ($coolec as $item) {

            $permissionExsit = Permission::where('slug',$item->as)->first();

            if (! isset($permissionExsit)){
                $permission = new Permission();
                $permission->name = $item->as;
                $permission->slug = $item->as;
                $permission->body = $item->as;
                $permission->save();
            }

        }

        $permissions = Permission::latest()->paginate(10);
        return view('site.admin.permissions.all' ,  compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('site.admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'name' => 'required',
            'slug' => 'required',
            'body' => 'required',
        ]);

        Permission::create($request->all());

        return redirect(route('permissions.index'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('site.admin.permissions.edit' , compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request , [
            'name' => 'required',
            'slug' => 'required',
            'body' => 'required',
        ]);

        $permission->update($request->all());
        return redirect(route('permissions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return back();
    }
}
