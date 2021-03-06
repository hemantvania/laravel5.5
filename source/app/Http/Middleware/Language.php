<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Config;
use Session;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($lang = Session::get('lang')) {
            App::setLocale($lang);
        }
        return $next($request);
    }

}
