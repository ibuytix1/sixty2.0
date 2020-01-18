<?php

namespace App\Http\Middleware;

use Closure;

class CheckOrganizerLogin
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
        if(!$request->session()->has('organizer_data'))
         {
            return redirect('/organizer');
        }
        return $next($request);
    }
}
