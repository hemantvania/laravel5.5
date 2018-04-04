<?php

namespace App\Http\Controllers\Admin;

use App\UsersSchools;
use Illuminate\Http\Request;
use App\User;
use App\UserMeta;
use App\Http\Requests\UserAddAdmin;
use App\Http\Requests\UserUpdateAdmin;
use App\School;
use App\Userrole;
use App\Classes;
use App\Countries;
use Input;
use Hash;
use Redirect;
use Yajra\DataTables\DataTables;
use App\RolesCountry;
use App\Http\Controllers\Controller;
use App;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.users.index");
    }

    /**
     * Process datatables ajax request.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $users = User::getUserList();
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return $this->generateAction($user);
            })
            ->make(true);
    }

    /**
     * Process datatables ajax request Generate Action Field.
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateAction($user)
    {

        $output = "";
        if ($user->deleted_at) {
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $user->id . '" data-toggle="tooltip" title="Restore" class="restore-adminusers btn btn-primary"><i class="fa fa-undo"></i></a>';
            $output .= '</div>';
        } else {
            $url = generateLangugeUrlAdmin(App::getLocale(), url("/users/" . $user->id . "/edit"));
            $output .= '<div class="btn-group">';
            $output .= '<a href="' . $url . '" class="btn btn-primary" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i ></a>';
            $output .= '</div>';
            $output .= '&nbsp;';
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $user->id . '" class="remove-adminusers btn btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o" ></i ></a>';
            $output .= '</div>';
        }
        return $output;
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $school = new School();
        $schoolsList = $school->getList();
        $userrole = new Userrole();
        $rolesList = $userrole->getList();
        $classes = new Classes();
        $classList = $classes->getClassList();
        $countries = new Countries();
        $countrieList = $countries->getCountryList();
        return view("admin.users.add", compact('schoolsList', 'rolesList', 'classList', 'countrieList'));
    }

    /**
     * Store a newly created resource in storage.
     * @param UserAddAdmin $request
     * @return mixed
     */
    public function store(UserAddAdmin $request)
    {
        $user = new User();
        $data = $request->all();
        $request['password'] = Hash::make($request->get('password'));
        $create = $user->createUserAdmin($request);
        if ($create) {
            return Redirect::to('admin/users')->with('message', __('adminuser.addsuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to('admin/users/create')->with('message', __('adminuser.failure'))->with('class', 'alert-danger');
        }
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
        $user = new User();
        $userDetail = $user->getUserById($id);
        $school = new School();
        $schoolsList = $school->getList();
        $roleCountry = new RolesCountry();
        $rolesList = $roleCountry->getRoleByCountry($userDetail->userMeta->country);
        $countries = new Countries();
        $countrieList = $countries->getCountryList();
        $userSchools = new UsersSchools();
        $user_schools = $userSchools->getUserSchools($id);
        return view("admin.users.add", compact('userDetail', 'schoolsList', 'rolesList', 'classList', 'countrieList', 'user_schools'));
    }

    /**
     * Update the specified resource in storage.
     * @param UserUpdateAdmin $request
     * @param $id
     * @return mixed
     */
    public function update(UserUpdateAdmin $request, $id)
    {
        $updateUser = new User();
        $updateUser = $updateUser->updateUser($request, $id);
        $updateUserMeta = new UserMeta();
        $updateMeta = $updateUserMeta->updateUserData($request, $id);
        $userSchools = new UsersSchools();
        $updateSchools = $userSchools->updateUserSchools($request, $id);
        if ($updateUser == true && $updateMeta == true && $updateSchools == true) {
            return Redirect::to('admin/users')->with('message', __('adminuser.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to('admin/users/' . $id . '/edit')->with('message', __('adminuser.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = new User();
        $checkRecord = $user->checkUserExist($id);
        if ($checkRecord) {
            $userDelete = $user->deleteUser($id);
            if ($userDelete) {
                return response()->json([
                    'status' => true,
                    'message' => __('adminuser.deletesuccess')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('adminuser.failure')
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminuser.norecordsfound')
            ]);
        }
    }

    /**
     * Restore the specified resource in storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $user = new User();
        $restoreUser = $user->restoreRecord($id);
        if ($restoreUser) {
            return response()->json([
                'status' => true,
                'message' => __('adminuser.restoresuccess')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminuser.failure')
            ]);
        }
    }

    /**
     * Validation of Zip code
     * @param $zip
     * @param $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function zipValidate($zip, $country)
    {
        $regex = array(
            "US" => "^\d{5}([\-]?\d{4})?$",
            "UK" => "^(GIR|[A-Z]\d[A-Z\d]??|[A-Z]{2}\d[A-Z\d]??)[ ]??(\d[A-Z]{2})$",
            "DE" => "\b((?:0[1-46-9]\d{3})|(?:[1-357-9]\d{4})|(?:[4][0-24-9]\d{3})|(?:[6][013-9]\d{3}))\b",
            "CA" => "^([ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ])\ {0,1}(\d[ABCEGHJKLMNPRSTVWXYZ]\d)$",
            "FR" => "^(F-)?((2[A|B])|[0-9]{2})[0-9]{3}$",
            "IT" => "^(V-|I-)?[0-9]{5}$",
            "AU" => "^(0[289][0-9]{2})|([1345689][0-9]{3})|(2[0-8][0-9]{2})|(290[0-9])|(291[0-4])|(7[0-4][0-9]{2})|(7[8-9][0-9]{2})$",
            "NL" => "^[1-9][0-9]{3}\s?([a-zA-Z]{2})?$",
            "ES" => "^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$",
            "DK" => "^([D-d][K-k])?( |-)?[1-9]{1}[0-9]{3}$",
            "SE" => "^(s-|S-){0,1}[0-9]{3}\s?[0-9]{2}$",
            "BE" => "^[1-9]{1}[0-9]{3}$",
            "1" => "^(?:FI)*(\d{5})$", // Finland
            "2" => "^(?:SE)*(\d{5})$" // Sweden
        );

        if ($regex[$country]) {

            if (!preg_match("/" . $regex[$country] . "/i", $zip)) {
                return response()->json([
                    'status' => false,
                ]);
            } else {
                return response()->json([
                    'status' => true,
                ]);
            }
        } else {
            //Validation not available
        }
    }
}
