<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UserDetails;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function test()
    {
        /*$roles = \DB::table('userroles')->pluck('role');

        foreach ($roles as $name => $title) {
            echo '<pre>'.$name.' => '.$title;
        }

        echo "<br>Users: ". \DB::table('users')->count();*/

        $users = DB::table('users')->paginate(1);

        return view('pages.home',compact('users'));
    }

    public function userDetails(){
        return view('auth.register-details');
    }

    public function RegisterDetails(Request $request)
    {
        $save = UserDetails::saveUserDetails($request->all());

        if($save)
        {
            return redirect()->route('home');
        }

    }
}
