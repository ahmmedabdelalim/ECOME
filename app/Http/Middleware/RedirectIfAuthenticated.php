<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(  $request, Closure $next, $guards= null)
    {
        if ($guards == "admin" && Auth::guard($guards)->check()) {
            return redirect('/admin');
        }
        if ($guards == "user" && Auth::guard($guards)->check()) {
            return redirect('/user');
        }



       /* if (Auth::guard($guards)->check()) {
            if ($guards == 'admin')
                return redirect(RouteServiceProvider::ADMIN);
            else
                return redirect(RouteServiceProvider::USER);
        }*/


        return $next($request);
}
}
