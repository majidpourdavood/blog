<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return string
     */

    public function username()
    {
        $identity = request()->input('identity');
        if (filter_var($identity, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
            request()->merge([$field => $identity]);
            return $field;
        }

    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated($request, $user)
    {
        if (auth()->check()) {
            if (auth()->user()->active == 0) {
                auth()->logout();
                alert()->error(translate('Your account has not been activated yet.'), translate('Account activation'))
                    ->confirmButton(translate('OK'))->autoclose(60000);
                return back();
            }
        }

        if (auth()->user()->hasRole('admin')) {
            return redirect()->intended('/admin/dashboard');
        }
        return redirect()->intended('/');


    }

}
