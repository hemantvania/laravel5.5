<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class isVeified
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
        if(Auth::user()->role == 1) // 1 = admin
        {
            return redirect('/admin/dashboard');

        }elseif(Auth::user()->UserDetails == null){

            return redirect()->route('userDetails');

        }
        return $next($request);
    }
}
