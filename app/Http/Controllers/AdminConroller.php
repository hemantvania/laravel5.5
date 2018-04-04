<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class AdminConroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = User::getUsers();
       // echo "<pre>"; print_r($users); die();
        return view('admin.users', compact('users'));
    }
}
