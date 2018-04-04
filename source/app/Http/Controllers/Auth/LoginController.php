<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App;
use Auth;
use App\User;
use App\Events\UserLogin;
use App\UsersAtivityTracker;
use Session;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get Login
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
     * Overriding the logout method from Illuminate\Foundation\Auth\AuthenticatesUsers
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        // Building namespace for Redis
        $id = Auth::user()->id;
        $namespace = 'vdeskusers:' . $id;
        \Event::fire(new App\Events\UserLogout($id));
        $activityid = Session::get('useractivity_id');
        $loggedintime = Carbon::createFromTimestamp(strtotime(Session::get('logged_time')));
        $loggedtime = Carbon::now();
        $diffhours = $loggedintime->diffInMinutes($loggedtime, true);
        $activity = new UsersAtivityTracker();
        $activity->deactivateTracker($activityid, $loggedtime, $diffhours);
        // Deleting user from redis database when they log out
        Redis::DEL($namespace);
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/');
    }
}
