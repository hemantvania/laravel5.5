<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Input;
use Hash;
use Redirect;
use App\Http\Requests\AdminLoginRequest;

class AdminController extends Controller
{
    /**
     * Get Login
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        if (Auth::check()) {
            return view('admin.dashboard.dashboard');
        } else {
            return redirect::intended('/home');
        }
    }

    /**
     * Post back handler
     * @param AdminLoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(AdminLoginRequest $request)
    {

        try {
            $data = array(
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            );
            if (User::generalLogin($data)) {
                $id = Auth::user()->id;
                $user = User::find($id);
                $userrole = $user->userrole;
                if ($userrole == 10 || $userrole == 1) {
                    return redirect::intended('/admin/dashboard');
                } else {
                    return redirect::intended('/home');
                }
            } else {
                return redirect('admin/login')->with('message', 'Username or password is wrong')->with('class', 'alert-danger');
            }
        } catch (Exception $e) {
            return Redirect::to('/admin/login')->with('message', 'The following errors occurred')->with('class', 'error')->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Get Logged out
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getLogout()
    {
        if (Auth::user()->userrole == '3') {
            Auth::logout();
            return redirect('login');
        } else {
            Auth::logout();
            return redirect('otherlogin');
        }
    }
}
