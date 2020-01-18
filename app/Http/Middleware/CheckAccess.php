<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CheckAccess
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
    $access_role = explode(',',Session::get('user_data')['roles']);
      if(!$request->user()->hasRole($role)) 
      {

      }
      return $next($request);
    }
}
