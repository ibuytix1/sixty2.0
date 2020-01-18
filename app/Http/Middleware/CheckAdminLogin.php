<?php

namespace App\Http\Middleware;
use Closure;
use Session;

class CheckAdminLogin
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
         if(!$request->session()->has('user_data'))
         {
            return redirect(url(config('constants.ADMIN_URL')));
        }
        return $next($request);
    }
    
}
