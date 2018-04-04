<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AdminAuthentication
{
    /**
     * AdminAuthentication constructor.
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
            if ($request->user()->userrole != '5' && $request->user()->userrole != '1' && $request->user()->userrole != '6') {
                return redirect('/');
            }
        } else {
            return redirect()->guest('login');
        }
        return $next($request);
    }
}
