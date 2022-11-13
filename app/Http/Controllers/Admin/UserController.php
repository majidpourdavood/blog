<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('site.admin.user.all', compact('users'));
    }


    public function userPermissions(User $user)
    {
        return view('site.admin.user.permissions', compact('user'));
    }


    public function updateUserPermissions(Request $request, User $user)
    {

        $user->permissions()->sync($request->input('permission_id'));
        return redirect()->route('users.index');
    }


    public function create()
    {
        return view('site.admin.user.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $codeNumber = randomNumber(9);
        if (in_array(trim($codeNumber), User::all()->pluck('codeNumber')->toArray())) {
            $codeNumber = randomNumber(9);
        }

        $user = new User();
        $user->name = $request->name;
        $user->lastName = $request->lastName;
        $user->body = $request->body;
        $user->email = $request->email;
        $user->codeNumber = $codeNumber;

        if ($request->active == 0) {
            $user->active = 0;
        } else if ($request->active == 1) {
            $user->active = 1;
        }
        $generatePassword = $request->password;
        if (isset($request->password)) {
            $user->password = Hash::make($generatePassword);
        } else {
            $generatePassword = generateRandomString(8);
            $user->password = Hash::make($generatePassword);
        }

        $BASE_PATH = env('BASE_PATH');
        if ($request->hasFile('image')) {
            $filename = $request->file('image');
            $name = sha1(time() . $filename->getClientOriginalName());
            $extension = $filename->getClientOriginalExtension();
            $filename = "{$name}.{$extension}";
            $request->image->move(base_path($BASE_PATH .'/userImage/'), $filename);
            $user->image = '/userImage/' . $filename;
        }

        $user->save();

        $role_id = $request->input('role_id');
        if (isset($role_id) && $role_id != 0) {
            $user->roles()->sync($request->input('role_id'));
        } else {
            $user->roles()->sync([]);
        }

        alert()->success(translate('User registered successfully'), translate('User registration'))
            ->confirmButton(translate('OK'))->autoclose('3000');
        return redirect()->route('users.index');
    }


    public function edit(User $user)
    {
        return view('site.admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);
        $user = User::findOrFail($id);

        $userExistEmail = User::
        where('email', $request->email)
            ->where('id', "!=", $user->id)
            ->first();
        if (isset($userExistEmail)) {
            alert()->error(translate('Email is already selected.'), translate('error'))
                ->confirmButton(translate('OK'))
                ->autoclose(60000);
            return redirect()->back()->withInput($request->input());
        }

        $user->name = $request->name;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->body = $request->body;

        if ($request->active == 0) {
            $user->active = 0;
        } else if ($request->active == 1) {
            $user->active = 1;
        }
        $generatePassword = $request->password;

        if ($generatePassword) {
            $user->password = Hash::make($generatePassword);
        }

        $BASE_PATH = env('BASE_PATH');
        if ($request->hasFile('image')) {
            $filename = $request->file('image');
            $name = sha1(time() . $filename->getClientOriginalName());
            $extension = $filename->getClientOriginalExtension();
            $filename = "{$name}.{$extension}";
            $request->image->move(base_path($BASE_PATH .'/userImage/'), $filename);
            $user->image = '/userImage/' . $filename;
        }
        $user->update();

        $role_id = $request->input('role_id');
        if (isset($role_id) && $role_id != 0) {
            $user->roles()->sync($request->input('role_id'));
        } else {
            $user->roles()->sync([]);
        }

        alert()->success(translate('User edited successfully'), translate('Edit user'))
            ->confirmButton(translate('OK'))->autoclose('3000');
        return redirect()->route('users.index');
    }


    public function showResetForm(User $user)
    {
        return view('site.admin.user.resetpassword', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $generatePassword = $request->password;
        if ($generatePassword) {
            $user->password = Hash::make($generatePassword);
        }
        $user->update();

        alert()->success(translate('User edited successfully'), translate('Edit user'))
            ->confirmButton(translate('OK'))->autoclose('3000');
        return redirect()->route('users.index');
    }


    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }
}
