<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Hash;
use App\User;


class ChangePassword extends Controller
{
    //
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
     * Change Password For all user
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(UserChangePasswordRequest $request)
    {

        $user = Auth::user();
        $curPassword = $request->get('curPassword');
        $newPassword = $request->get('newPassword');
        $confNewPassword = $request->get('confNewPassword');

        if (Hash::check($curPassword, $user->password)) {

            $generatedNew = Hash::make($newPassword);

            $user_id = $user->id;
            $obj_user = User::find($user_id);
            $obj_user->password = $generatedNew;
            $obj_user->save();

            return response()->json(["status" => true, 'message' => 'Password Change Successfully']);
        } else {
            return response()->json(["status" => false, 'message' => 'Current password does not match.']);
        }


    }
}
