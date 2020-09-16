<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('guest')->check()) {
            return $next($request);
        } else {
            return redirect(route("guest-login"));
        }
    }
}
