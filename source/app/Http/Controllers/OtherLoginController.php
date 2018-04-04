<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Redirect;
use App;
use App\Events\UserLogin;
use App\UsersAtivityTracker;
use Session;
use Carbon\Carbon;


class OtherLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Other Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * OtherLoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Login Handler
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Request $request)
    {
        // Validate Form Data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $data = array(
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        );
        $loggedtime = Carbon::now();
        $clientip = $request->getClientIp();
        $browser = $request->server('HTTP_USER_AGENT');
        $logout = Carbon::today();
        // Attempt To login
        if (User::generalLogin($data)) {
            // Building namespace for Redis
            $id = Auth::user()->id;
            //$prefferance = Auth::user()->UserMeta->user_preference;
            if(Auth::user()->rolename != 1) {
                $prefferance = Auth::user()->UserMeta->language;
            } else {
                $prefferance = '';
            }
            $namespaces = 'vdeskusers:' . $id;
            // Getting the expiration from the session config file. Converting from minutes to seconds.
            $expire = config('session.lifetime') * 60;
            // Setting redis using id as value
            Redis::set($namespaces, $id);
            Redis::EXPIRE($namespaces, $expire);

            \Event::fire(new App\Events\UserLogin($id));
            $activity = new UsersAtivityTracker();
            $activityid = $activity->activateTracker($id, $clientip, $browser, $loggedtime, $logout);
            $request->session()->put('useractivity_id', $activityid);
            $request->session()->put('logged_time', $loggedtime);
            if(empty($prefferance)) {
                $prefferance = App::getLocale();
            }
            return redirect(generateLangugeUrl($prefferance, url('home')));
        } else {
            return redirect()->back()->with('error', 'Username or password is wrong')->with('class', 'error')->withInput($request->only('email', 'remeber'));
        }
    }

    /**
     * Show login form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showlogin()
    {
        return view('teacher.login');
    }
}
