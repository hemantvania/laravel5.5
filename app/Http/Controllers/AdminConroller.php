<?php

namespace App\Http\Controllers;

use App\UserDetails;
use Illuminate\Http\Request;

use Auth;
use App\User;
use Flash;
use App\UserRoles;
use Redirect;
use Hash;

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
        $roles = UserRoles::all();
        return view('admin.edit-user',compact('user','roles'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::with('userDetails')->with('role')->find($id);

        if(!$user)
        {
            return Redirect::to('admin/view-user/userid/'.$id)->with('error','User not found!');
        }

        $user->name =   $request->name;
        $user->email =   $request->email;
        $user->mobile_no =   $request->mobile_no;
        $user->role =   $request->role;
        $user->save();

        $userDetails = $user->userDetails;

        if(!$userDetails)
        {
            $userDetails = new UserDetails();
        }

        $userDetails->user_id = $id;
        $userDetails->occupassion =   $request->occupassion;
        $userDetails->city =   $request->city;
        $userDetails->state =   $request->state;
        $userDetails->zip =   $request->zip;
        $userDetails->save();

        return Redirect::to('admin/view-user/userid/'.$id)->with('success','User data has updated successfully!');
    }

    public function addNewUser()
    {
        $roles = UserRoles::all();
        return view('admin.add-new-user',compact('roles'));
    }

    public function addUser(Request $request)
    {
       // return $request->all();

        $user['name'] = $request->name;
        $user['email'] = $request->email;
        $user['mobile_no'] = $request->mobile_no;
        $user['password'] = Hash::make($request->password);
        $user['role'] = $request->role;

        $userAdd = User::Create($user);

        if($userAdd->id)
        {
            $userDetails['user_id'] = $userAdd->id;
            $userDetails['occupassion'] = $request->occupassion;
            $userDetails['city'] = $request->city;
            $userDetails['state'] = $request->state;
            $userDetails['zip'] = $request->zip;

            dd($userDetails);
            $details = UserDetails::Create($userDetails);
        }
        else
        {

        }

        return Redirect::to('admin/users')->with('success','User data has updated successfully!');
    }

    public function deleteUser($id)
    {

        $user = User::with('userDetails')->find($id);

        if(!$user)
        {
            return Redirect::to('admin/users')->with('error','User not found!');;
        }
        if($user->userDetails) {
            $user->userDetails()->delete();
        }
        $delete = $user->delete();
        if($delete)
        {
            return Redirect::to('admin/users')->with('success','User data has deleted successfully!');;
        }
        else
        {
            return Redirect::to('admin/users')->with('error','There is something wrong!');
        }

    }
}
