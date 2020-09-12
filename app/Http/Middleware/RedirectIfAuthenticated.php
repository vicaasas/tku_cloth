<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if(Auth::guard($guard)->check()) {
            if($guard == "student"){
                return redirect()->route('student.page');
            }
            else if($guard == "represent"){
                return redirect()->route('represent.page');
            }
            else if($guard == "department"){
                return redirect()->route('department.page');
            }
            else{
                return redirect(RouteServiceProvider::HOME);
            }
            
        }

        return $next($request);
    }
}
