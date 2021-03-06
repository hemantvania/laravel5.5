<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Middleware\UserDashboardRedirectionMiddleware;
use App;
use App\UserMeta;
class StudentMiddleware
{
    /**
     * StudentMiddleware constructor.
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
            if ($request->user()->userrole != '3') {
                return (new UserDashboardRedirectionMiddleware())->handle($request, $next);
            }
            $objMeta = new UserMeta();
            $objMeta->updateUserPrefferrence(App::getLocale());
        } else {

            return redirect()->guest('login');
        }
        return $next($request);
    }
}
