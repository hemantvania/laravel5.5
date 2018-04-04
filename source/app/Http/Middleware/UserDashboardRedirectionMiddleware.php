<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App;

class UserDashboardRedirectionMiddleware
{

    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        switch ($request->user()->userrole) {
            case '1':
                return redirect(generateLangugeUrlAdmin(App::getLocale(), url('/dashboard')));
                break;
            case '2':
                return redirect(generateLangugeUrl(App::getLocale(), url('/teacher/dashboard')));
                break;
            case '3':
                return redirect(generateLangugeUrl(App::getLocale(), url('/home')));
                break;
            case '4':
                return redirect(generateLangugeUrl(App::getLocale(), url('/schooldistrict/dashboard')));
                break;
            case '5':
                return redirect(generateLangugeUrl(App::getLocale(), url('/portaladmin/dashboard')));
                break;
            case '6':
                return redirect(generateLangugeUrl(App::getLocale(), url('/school/dashboard')));
                break;
        }
        return $next($request);
    }
}
