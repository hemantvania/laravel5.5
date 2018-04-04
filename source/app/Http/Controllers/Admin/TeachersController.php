<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserMeta;
use App\Http\Requests\UserAddAdmin;
use App\Http\Requests\UserUpdateAdmin;
use App\School;
use App\Userrole;
use App\Teachers;
use Yajra\DataTables\DataTables;
use App\Countries;
use Input;
use Hash;
use Redirect;
use Auth;
use App\UsersSchools;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.school.index_teacher');
    }

    /**
     * this function is using to get all teachers list
     * @return mixed
     */
    public function showTeachers()
    {
        $teachers = Teachers::getTeacherList();
        return Datatables::of($teachers)
            ->addColumn('action', function ($teachers) {
                return $this->generateAction($teachers);
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
            $url = url("/admin/schools/teachers/" . $user->id . "/edit");
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
        $authUser = Auth::user();
        $school = new School();
        $schoolsList = $school->getList();
        return view("admin.school.teacher_add", compact('authUser', 'schoolsList'));
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
            return Redirect::to('admin/schools/teachers')->with('message', __('adminuser.teacher_add_success'))->with('class', 'alert-success');
        } else {
            return Redirect::to('admin/schools/teachers/create')->with('message', __('adminuser.failure'))->with('class', 'alert-danger');
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
        $authUser = Auth::user();
        $school = new School();
        $schoolsList = $school->getList();
        $userSchools = new UsersSchools();
        $user_schools = $userSchools->getUserSchools($id);
        return view("admin.school.teacher_add", compact('authUser', 'schoolsList', 'userDetail', 'user_schools'));
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
            return Redirect::to('admin/schools/teachers')->with('message', __('adminuser.update_teacher_success'))->with('class', 'alert-success');
        } else {
            return Redirect::to('admin/schools/teachers/' . $id . '/edit')->with('message', __('adminuser.failure'))->with('class', 'alert-danger');
        }
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
}
