<?php

namespace App\Http\Controllers;

use App;
use Yajra\DataTables\DataTables;
use Auth;
use Redirect;
use App\User;
use App\UserMeta;
use App\School;
use App\Students;
use App\Teachers;
use App\Classes;
use App\UsersSchools;
use App\Http\Requests\ClassAddAdmin;
use App\EducationType;
use App\Http\Requests\ClassUpdateAdmin;
use App\Http\Requests\UserAddAdmin;
use App\Http\Requests\UserUpdateAdmin;
use App\Http\Requests\ContentAddRequest;
use App\Http\Requests\ContentUpdateRequest;
use App\Http\Requests\ContentDeleteRequest;
use App\UsersClasses;
use App\RolesCountry;
use App\Material;
use App\MaterialCategory;

class SchoolController extends Controller
{
    /**
     * SchoolController constructor.
     */
    public function __construct()
    {
        $this->middleware('school');
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('school.dashboard');
    }

    /**
     * Display Teachers View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function teachers()
    {
        return view('school.teachers');
    }

    /**
     * Add Teacher
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addteacher()
    {
        $authUser = Auth::user();
        $school = new School();
        $schoolsList = $school->getList();
        return view('school.addteacher', compact('authUser', 'schoolsList'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function editTeacher($id)
    {
        $user = new User();
        $userDetail = $user->getUserById($id);
        $authUser = Auth::user();
        $school = new School();
        $schoolsList = $school->getList();
        $userSchools = new UsersSchools();
        $user_schools = $userSchools->getUserSchools($id);
        return view("school.addteacher", compact('authUser', 'schoolsList', 'userDetail', 'user_schools'));
    }

    /**
     * Store a newly created resource in storage.
     * @param UserAddAdmin $request
     * @return mixed
     */
    public function storeTeacher(UserAddAdmin $request)
    {
        $userData = array(
            'name'                  => $request->get('name'),
            'last_name'             => $request->get('last_name'),
            'email'                 => $request->get('email'),
            'password'              => $request->get('password'),
            'userrole'              => $request->get('userrole'),
            'country'               => $request->get('country'),
            'ssn'                   => $request->get('ssn'),
            'gender'                => $request->get('gender'),
            'addressline1'          => $request->get('addressline1'),
            'addressline2'          => $request->get('addressline2'),
            'phone'                 => $request->get('phone'),
            'city'                  => $request->get('city'),
            'zip'                   => $request->get('zip'),
            'schoolId'              => $request->get('schoolId'),
            'default_school'        => $request->get('default_school'),
            'enable_share_screen'   => $request->get('enable_share_screen'),
            'default_language'      => $request->get('default_language')
        );
        if ($request->hasFile('profileimage')) {
            $userData['profileimage'] = $request->file('profileimage')->store("userprofile");
        } else {
            $userData['profileimage'] = '';
        }

        if(!empty($request->get('state'))){
            $userData['state'] = $request->get('state');
        } else {
            $userData['state'] = '';
        }

        $user = new User();
        $userid =  $user->createUser($userData);
        if(!empty($userid)){
            $create = true;
            //Creating User Meta
            $userData['userid'] = $userid;
            $objUserMeta = new UserMeta();
            $metaid =  $objUserMeta->createUserMeta($userData);
            // Assign User to Schools
            $objUserSchools = new UsersSchools();
            if(!empty( $userData['schoolId'])){
                foreach ($userData['schoolId'] as $schoolids){
                    $objUserSchools->storeUsersSchool($userid,$schoolids);
                }
            }
        }

        if ($create) {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/teacher/')->with('message', __('adminuser.teacher_add_success'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/teacher/add')->with('message', __('adminuser.tokenexpire'))->with('class', 'alert-danger');
        }
    }

    /**
     * Update the specified resource in storage.
     * @param UserUpdateAdmin $request
     * @param $id
     * @return mixed
     */
    public function updateTeacher(UserUpdateAdmin $request, $id)
    {
        $userData = array(
            'name'      => $request->get('name'),
            'last_name' => $request->get('last_name'),
            'email'     => $request->get('email'),
            'userrole'  => $request->get('userrole'),
            'password'  => $request->get('password'),
        );
        $updateUser = new User();
        $updateUser = $updateUser->updateUser($userData, $id);
        $userMeta = array(
            'country'               => $request->get('country'),
            'default_school'        => $request->get('default_school'),
            'ssn'                   => $request->get('ssn'),
            'gender'                => $request->get('gender'),
            'addressline1'          => $request->get('addressline1'),
            'addressline2'          => $request->get('addressline2'),
            'phone'                 => $request->get('phone'),
            'city'                  => $request->get('city'),
            'zip'                   => $request->get('zip'),
            'default_language'      => $request->get('default_language'),
            'enable_share_screen'   => $request->get('enable_share_screen'),
        );

        if (!empty($request->hasFile('profileimage'))) {
            $userMeta['profileimage'] = $request->file('profileimage')->store("userprofile");
        } else {
            $userMeta['profileimage'] = $request->get('userimage');
        }

        if ($request->has('remove_logo')) {
            \File::delete(storage_path('app/' . $request->get('userimage')));
            $userMeta['profileimage'] = '';
        }

        if(!empty($request->get('state'))){
            $userMeta['state'] = $request->get('state');
        } else {
            $userMeta['state'] = '';
        }

        $updateUserMeta = new UserMeta();
        $updateMeta     = $updateUserMeta->UpdateUserMeta($userMeta, $id);
        $schoolIds      = $request->get('schoolId');

        $objUserSchools = new UsersSchools();
        $objUserSchools->deleteUsersSchool($id);
        foreach ($schoolIds as $schooid){
            $updateSchools = true;
            $objUserSchools->storeUsersSchool($id,$schooid);
        }

        if ($updateUser == true && $updateMeta == true && $updateSchools == true) {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/teacher/')->with('message', __('adminuser.update_teacher_success'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/teacher/' . $id . '/edit')->with('message', __('adminuser.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Classes View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function classes()
    {
        return view('school.classes');
    }

    /**
     * Class list
     * @return mixed
     */
    public function classlist()
    {
        $class = new Classes();
        $classes = $class->getClassList();
        return Datatables::of($classes)
            ->addColumn('action', function ($classes) {
                return $this->generateAction($classes);
            })
            ->make(true);
    }

    /**
     * Process datatables ajax request Generate Action Field.
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateAction($classes)
    {
        $output = "";
        if ($classes->deleted_at) {
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $classes->id . '" data-toggle="tooltip" data-original-title="Restore" class="restore-class btn btn-primary"><i class="fa fa-undo"></i></a>';
            $output .= '</div>';
        } else {
            $url = url(App::getLocale() . '/' . generateUrlPrefix() . "/classes/" . $classes->id . "/edit");
            $output .= '<div class="btn-group">';
            $output .= '<a href="' . $url . '" class="btn btn-primary marbot" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i ></a>';
            $output .= '</div>';
            $output .= '&nbsp;';
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $classes->id . '" class="remove-class btn btn-danger marbot" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o" ></i ></a>';
            $output .= '</div>';
        }
        return $output;
    }

    /**
     * Create Class Handler
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createClass()
    {
        $school = new School();
        $schoolsList = $school->getList();
        $edutcationType = new EducationType();
        $edutcationTypeList = $edutcationType->getTypes();
        $usersSchools = new UsersSchools();
        $userSchoolId = $usersSchools->getUserSchools(Auth::user()->id);
        $teachers = User::where('users.userrole', '=', '2')
            ->leftJoin('user_schools', 'user_schools.user_id', 'users.id')
            ->whereIn('user_schools.school_id', $userSchoolId)
            ->join('user_metas', 'user_metas.userId', '=', 'users.id')->get();
        return view('school.addclass', compact('schoolsList', 'edutcationTypeList', 'teachers'));
    }

    /**
     * Store Class
     * @param ClassAddAdmin $request
     * @return mixed
     */
    public function storeClass(ClassAddAdmin $request)
    {
        // Add class details
        $classData = array(
            'className' => $request->get('className'),
            'schoolId' => $request->get('schoolId'),
            'educationTypeId' => $request->get('educationTypeId'),
            'standard' => $request->get('standard'),
            'class_duration' => $request->get('class_duration'),
            'class_size' => $request->get('class_size'),
        );
        $class = new Classes();
        $addClass = $class->addClassAdmin($classData);
        // Add users class details
        if ($addClass > 0) {
            $classUsers = $request->get('user_id');
            $usersClass = new UsersClasses();
            $usersClass->assignClass($classUsers, $addClass);
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/classes/')->with('message', __('adminclasses.addsuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/classes/create')->with('message', __('adminclasses.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Edit Class
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View]
     */
    public function classEdit($id)
    {
        $class = new Classes();
        $classDetail = $class->getClassById($id);
        $school = new School();
        $schoolsList = $school->getList();
        $edutcationType = new EducationType();
        $edutcationTypeList = $edutcationType->getTypes();
        $usersSchools = new UsersSchools();
        $userSchoolId = $usersSchools->getUserSchools(Auth::user()->id);
        $teachers = User::where('users.userrole', '=', '2')
            ->leftJoin('user_schools', 'user_schools.user_id', 'users.id')
            ->whereIn('user_schools.school_id', $userSchoolId)
            ->join('user_metas', 'user_metas.userId', '=', 'users.id')->get();
        $usersClass = new UsersClasses();
        $assignedTeachers = $usersClass->getTeachersOfClass($id);
        return view("school.addclass", compact('classDetail', 'schoolsList', 'edutcationTypeList', 'teachers', 'assignedTeachers'));
    }

    /**
     * Update the specified resource in storage.
     * @param ClassUpdateAdmin $request
     * @param $id
     * @return mixed
     */
    public function classUpdate(ClassUpdateAdmin $request, $id)
    {
        $classData = array(
            'className' => $request->get('className'),
            'schoolId' => $request->get('schoolId'),
            'educationTypeId' => $request->get('educationTypeId'),
            'standard' => $request->get('standard'),
            'class_duration' => $request->get('class_duration'),
            'class_size' => $request->get('class_size'),
        );
        // update class details
        $class = new Classes();
        $updateClass = $class->classUpdate($classData, $id);
        // update users classes details
        if (!empty($request->get('user_id'))) {
            $teachers = $request->get('user_id');
            $usersClass = new UsersClasses();
            $usersClass->deleteUserClass($id);
            if (is_array($teachers) && count($teachers) > 0) {
                foreach ($teachers as $teacher) {
                    $usersClass->assignStudent($teacher, $id, 0);
                }
            }
        }
        if ($updateClass) {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/classes/')->with('message', __('adminclasses.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/classes/' . $id . '/edit')->with('message', __('adminclasses.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * this function is using to get all teachers list
     * @return mixed
     */
    public function teacherslist()
    {
        $teachers = Teachers::getTeacherList();
        return Datatables::of($teachers)
            ->addColumn('action', function ($teachers) {
                return $this->generateActionTeacher($teachers);
            })
            ->make(true);
    }

    /**
     * Process datatables ajax request Generate Action Field.
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateActionTeacher($user)
    {
        $output = "";
        if ($user->deleted_at) {
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $user->id . '" data-toggle="tooltip" title="Restore" class="restore-adminusers btn btn-primary"><i class="fa fa-undo"></i></a>';
            $output .= '</div>';
        } else {
            $url = url(App::getLocale() . '/' . generateUrlPrefix() . "/teacher/" . $user->id . "/edit");
            $output .= '<div class="btn-group">';
            $output .= '<a href="' . $url . '" class="btn btn-primary marbot" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i ></a>';
            $output .= '</div>';
            $output .= '&nbsp;';
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $user->id . '" class="remove-adminusers btn btn-danger marbot" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o" ></i ></a>';
            $output .= '</div>';
        }
        return $output;
    }

    /**
     * Studnets View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function students()
    {
        return view('school.students');
    }

    /**
     * Show Students
     * @return mixed
     */
    public function showStudents()
    {
        $students = Students::getStudentList();
        return Datatables::of($students)
            ->addColumn('action', function ($students) {
                return $this->generateStudents($students);
            })
            ->make(true);
    }

    /**
     * Process data tables ajax request Generate Action Field.
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateStudents($user)
    {

        $output = "";
        if ($user->deleted_at) {
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $user->id . '" data-toggle="tooltip" title="Restore" class="restore-adminusers btn btn-primary"><i class="fa fa-undo"></i></a>';
            $output .= '</div>';
        } else {
            $url = url(App::getLocale() . '/' . generateUrlPrefix() . "/students/" . $user->id . "/edit");
            $output .= '<div class="btn-group">';
            $output .= '<a href="' . $url . '" class="btn btn-primary marbot" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i ></a>';
            $output .= '</div>';
            $output .= '&nbsp;';
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $user->id . '" class="remove-adminusers btn btn-danger marbot" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o" ></i ></a>';
            $output .= '</div>';
        }
        return $output;
    }

    /**
     * Create New Students
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createStudents()
    {
        $authUser = Auth::user();
        $school = new School();
        $schoolsList = $school->getList();
        return view("school.add-student", compact('authUser', 'schoolsList'));
    }

    /**
     * Store New Data to database
     * @param UserAddAdmin $request
     * @return mixed
     */
    public function storeStudents(UserAddAdmin $request)
    {
        $user = new User();
        $userData = array(
            'name'          => $request->get('name'),
            'last_name'     => $request->get('last_name'),
            'email'         => $request->get('email'),
            'password'      => $request->get('password'),
            'userrole'      => $request->get('userrole'),
            'country'       => $request->get('country'),
            'ssn'           => $request->get('ssn'),
            'gender'        => $request->get('gender'),
            'addressline1'  => $request->get('addressline1'),
            'addressline2'  => $request->get('addressline2'),
            'phone'         => $request->get('phone'),
            'city'          => $request->get('city'),
            'zip'           => $request->get('zip'),
            'schoolId'          => $request->get('schoolId'),
            'default_school'    => $request->get('default_school'),
            'default_language'  => $request->get('default_language')
        );
        if ($request->hasFile('profileimage')) {
            $userData['profileimage'] = $request->file('profileimage')->store("userprofile");
        } else {
            $userData['profileimage'] = '';
        }

        if(!empty($request->get('state'))){
            $userData['state'] = $request->get('state');
        } else {
            $userData['state'] = '';
        }
        if (!empty($request->get('enable_share_screen'))) {
            $userData['enable_share_screen'] = $request->get('enable_share_screen');
        } else {
            $userData['enable_share_screen'] = 0;
        }
        $userid =  $user->createUser($userData);
        if(!empty($userid)){
            $create = true;
            //Creating User Meta
            $userData['userid'] = $userid;
            $objUserMeta = new UserMeta();
            $metaid =  $objUserMeta->createUserMeta($userData);
            // Assign User to Schools
            $objUserSchools = new UsersSchools();
            if(!empty( $userData['schoolId'])){
                foreach ($userData['schoolId'] as $schoolids){
                    $objUserSchools->storeUsersSchool($userid,$schoolids);
                }
            }
        }

        //$create = $user->createUserAdmin($userData);
        if ($create) {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/students/')->with('message', __('adminuser.addsuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/students/add')->with('message', __('adminuser.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Edit Students
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editStudents($id)
    {
        $user = new User();
        $userDetail = $user->getUserById($id);
        $authUser = Auth::user();
        $school = new School();
        $schoolsList = $school->getList();
        $userSchools = new UsersSchools();
        $user_schools = $userSchools->getUserSchools($id);
        return view("school.add-student", compact('authUser', 'schoolsList', 'userDetail', 'user_schools'));
    }

    /**
     * Update Students
     * @param UserUpdateAdmin $request
     * @param $id
     * @return mixed
     */
    public function updateStudents(UserUpdateAdmin $request, $id)
    {
        $userData = array(
            'name'      => $request->get('name'),
            'last_name' => $request->get('last_name'),
            'email'     => $request->get('email'),
            'userrole'  => $request->get('userrole'),
        );
        if (!empty($request->get('password'))) {
            $userData['password'] = $request->get('password');
        }
        $updateUser = new User();
        $updateUser = $updateUser->updateUser($userData, $id);
        $userMeta   = array(
            'country'           => $request->get('country'),
            'ssn'               => $request->get('ssn'),
            'gender'            => $request->get('gender'),
            'addressline1'      => $request->get('addressline1'),
            'addressline2'      => $request->get('addressline2'),
            'phone'             => $request->get('phone'),
            'city'              => $request->get('city'),
            'zip'               => $request->get('zip'),
            'default_school'    => $request->get('default_school'),
            'default_language'  => $request->get('default_language'),
        );


        if (!empty($request->hasFile('profileimage'))) {
            $userMeta['profileimage'] = $request->file('profileimage')->store("userprofile");
        } else {
            $userMeta['profileimage'] = $request->get('userimage');
        }

        if ($request->has('remove_logo')) {
            \File::delete(storage_path('app/' . $request->get('userimage')));
            $userMeta['profileimage'] = '';
        }

        if(!empty($request->get('state'))){
            $userMeta['state'] = $request->get('state');
        } else {
            $userMeta['state'] = '';
        }
        if (!empty($request->get('enable_share_screen'))) {
            $userMeta['enable_share_screen'] = $request->get('enable_share_screen');
        } else {
            $userMeta['enable_share_screen'] = 0;
        }

        $updateUserMeta = new UserMeta();
        $updateMeta = $updateUserMeta->UpdateUserMeta($userMeta, $id);

        $schoolIds      = $request->get('schoolId');
        $objUserSchools = new UsersSchools();
        $objUserSchools->deleteUsersSchool($id);
        foreach ($schoolIds as $schooid){
            $updateSchools = true;
            $objUserSchools->storeUsersSchool($id,$schooid);
        }

        if ($updateUser == true && $updateMeta == true && $updateSchools == true) {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/students/')->with('message', __('adminuser.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/students/' . $id . '/edit')->with('message', __('adminuser.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Will show auth users details to update
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myprofile()
    {
        $userDetail = Auth::user();
        $school = new School();
        $schoolsList = $school->getList();
        $roleCountry = new RolesCountry();
        $rolesList = $roleCountry->getRoleByCountry(Auth::user()->userMeta->country);
        $userSchools = new UsersSchools();
        $user_schools = $userSchools->getUserSchools(Auth::user()->id);
        $my_schools = $userSchools->getUserSchools(Auth::user()->id, false);
        return view("school.profile", compact('userDetail', 'schoolsList', 'user_schools', 'rolesList','my_schools'));
    }

    /**
     * Update User Profile Data
     * @param UserUpdateAdmin $request
     * @param $id
     * @return mixed
     */
    public function updateProfile(UserUpdateAdmin $request, $id)
    {

        $user = new PortalAdminController();
        $update = $user->userUpdate($request, $id, true);
        $locale = isset($request->default_language) ? $request->default_language : App::getLocale() ;
        if ($update) {
            return Redirect::to($locale . '/' . generateUrlPrefix() . '/profile')->with('message', __('adminuser.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to($locale . '/' . generateUrlPrefix() . '/teacher/dashboard')->with('message', __('adminuser.failure'))->with('class', 'alert-danger');
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
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function classDestroy($id)
    {
        $class = new Classes();
        $checkRecord = $class->checkRecordExist($id);
        if ($checkRecord) {
            $deleteClass = $class->deleteClass($id);
            if ($deleteClass) {
                return response()->json([
                    'status' => true,
                    'message' => __('adminclasses.deletesuccess')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('adminclasses.failure')
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminclasses.norecordsfound')
            ]);
        }
    }

    /**
     * Restore the specified resource in storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function classRestore($id)
    {
        $class = new Classes();
        $class = $class->restoreRecord($id);
        if ($class) {
            return response()->json([
                'status' => true,
                'message' => __('adminclasses.restoresuccess')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminclasses.failure')
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function materials()
    {
        return view("school.materials");
    }

    /**
     * Function is use for retrun material list on index
     * @return mixed
     */
    public function getMaterialDataAjax()
    {
        $objMaterial = new Material();
        $materials = $objMaterial->getMaterialList();

        return Datatables::of($materials)
            ->addColumn('delaction',function($material){
                return $this->generateDelAction($material);
            })
            ->addColumn('action', function ($material) {
                return $this->generateMaterialAction($material);
            })
            ->make(true);
    }

    /**
     * Delete Multiple
     * @param $material
     * @return string
     */
    public function generateDelAction($material){
        if(Auth::user()->id == $material->uploadBy) {
            return 'true';
        } else {
            return 'false';
        }
    }
    /**
     * Process data tables ajax request Generate Action Field.
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateMaterialAction($material)
    {

        $output = "";

            $editUrl = url(App::getLocale() . '/' . generateUrlPrefix() . "/materials/" . $material->id . "/edit");
            $output .= '<div class="btn-group">';
            $output .= '<a href="' . $editUrl . '" data-toggle="tooltip" title="Edit" class="btn btn-primary marbot"><i class="fa fa-edit"></i></a>';
            $output .= '</div>';
            $output .= '&nbsp;';
            if(Auth::user()->id == $material->uploadBy) {
                $output .= '<div class="btn-group">';
                $output .= ' <a href="javascript:void(0);" data-index="' . $material->id . '" data-toggle="tooltip" title="Delete" class="remove-contents btn btn-danger marbot"><i class="fa fa-trash-o" ></i ></a>';
                $output .= '</div>';
            }
        return $output;
    }

    /**
     * Function create for render view files for add new content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createMaterial()
    {
        $materialCategory = new MaterialCategory();
        $materialCategories = $materialCategory->getCategories();
        $types = getUploadContentTypes();
        return view("school.add-materials", compact('materialCategories', 'types'));
    }

    /**
     * Function is create for store material in DB
     * @param ContentAddRequest $request
     * @return mixed
     */
    public function storeMaterial(ContentAddRequest $request)
    {
        $materialData = array(
            'materialType' => $request->get('materialType'),
            'materialName' => $request->get('materialName'),
            'description' => $request->get('description'),
            'categoryId' => $request->get('categoryId'),
            'link' => $request->get('link'),
            'uploadcontent' => $request->file('uploadcontent'),
            'materialIcon' => $request->file('materialIcon'),
            'language'=>$request->get('default_language')
        );
        $create = Material::storeMaterial($materialData);
        if ($create) {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/materials/')->with('message', __('adminmaterial.addsuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/materials/add')->with('message', __('adminmaterial.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Function is create for render Form for Edit material
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editMaterial($id)
    {
        $getMaterial = Material::geMaterialById($id);
        $materialCategory = new MaterialCategory();
        $materialCategories = $materialCategory->getCategories();
        $types = getUploadContentTypes();
        return view('school.add-materials', compact('getMaterial', 'materialCategories', 'types'));
    }

    /**
     * Function is create for update content detail
     * @param ContentUpdateRequest $request
     * @param $id
     * @return mixed
     */
    public function updateMaterial(ContentUpdateRequest $request, $id)
    {
        $material = array(
            'materialType' => $request->get('materialType'),
            'materialName' => $request->get('materialName'),
            'description' => $request->get('description'),
            'categoryId' => $request->get('categoryId'),
            'link' => $request->get('link'),
            'uploadcontent' => $request->file('uploadcontent'),
            'materialIcon' => $request->file('materialIcon'),
            'remove_materialIcon' => $request->get('remove_materialIcon'),
            'language'=>$request->get('default_language')
        );
        $update = Material::updateMaterialDetail($material, $id);
        if ($update) {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/materials/')->with('message', __('adminmaterial.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/materials/' . $id . '/edit')->with('message', __('adminmaterial.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Function is create for destroy/delete material record
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyMaterial($id)
    {
        $checkRecord = Material::geMaterialById($id);
        if (!empty($checkRecord)) {
            $destroy = Material::destroyMaterialById($id);
            if ($destroy) {
                return response()->json([
                    'status' => true,
                    'message' => __('adminmaterial.deletesuccess')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('adminmaterial.failure')
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminmaterial.norecordsfound')
            ]);
        }
    }

    /**
     * Delete Selected Materials
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSelectedMaterial(ContentDeleteRequest $request){
        $materialsids = $request->get('materialsids');
        $del = false;
        foreach ($materialsids as $mid) {
            $checkRecord = Material::geMaterialById($mid);
            if (!empty($checkRecord)) {
                $destroy = Material::destroyMaterialById($mid);
                if ($destroy) {
                    $del = true;
                }
            }
        }
        if ($del == true) {
            return response()->json([
                'status' => true,
                'message' => __('adminmaterial.deletesuccess')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminmaterial.failure')
            ]);
        }

    }

    /**
     * Restore the specified resource in storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restoreMaterial($id)
    {
        $restoreUser = Material::restoreRecord($id);
        if ($restoreUser) {
            return response()->json([
                'status' => true,
                'message' => __('adminmaterial.restoresuccess')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminmaterial.failure')
            ]);
        }
    }
}
