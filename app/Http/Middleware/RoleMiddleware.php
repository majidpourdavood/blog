<?php

namespace App\Http\Middleware;

use App\Permission;
use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role= null, $permission = null)
    {

//        return $next($request);
        $permission = request()->route()->getName();

        if (auth()->user()->can($permission)) {
            return $next($request);
        }else{
            alert()->error(translate('Your role does not have access to this path.'))
                ->confirmButton(translate('OK'));
            return back();
        }

    }
}
