<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Hash;
use Input;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Change Password For Admin
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {

        $user = Auth::user();
        $curPassword = $request->get('curPassword');
        $newPassword = $request->get('newPassword');
        $confNewPassword = $request->get('confNewPassword');

        if (Hash::check($curPassword, $user->password)) {
            $user_id = $user->id;
            $obj_user = User::find($user_id)->first();
            $obj_user->password = Hash::make($newPassword);
            $obj_user->save();

            return response()->json(["status" => true, 'message' => 'Password Change Successfully']);
        } else {
            return response()->json(["status" => false, 'message' => 'Current password does not match.']);
        }
    }
}
