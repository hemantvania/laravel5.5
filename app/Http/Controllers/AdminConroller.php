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
        $users = User::getUsers(5);
        $TotalUsers = User::getUsers()->count();
        return view('admin.dashboard', compact('users', 'TotalUsers'));
    }

    public function users()
    {
        $users = User::getUsers();
        return view('admin.users', compact('users'));
    }

    public function viewUser($id)
    {
        $user =  User::viewUserDetails($id);
        return view('admin.view-user',compact('user'));
    }

    public function editUser($id)
    {
        $user =  User::viewUserDetails($id);
        return view('admin.edit-user',compact('user'));
    }
}
