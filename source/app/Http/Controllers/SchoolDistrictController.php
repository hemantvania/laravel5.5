<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Auth;
use Redirect;
use App\School;
use App\RolesCountry;
use App\UsersSchools;
use App\Http\Requests\UserUpdateAdmin;
use App\User;
use Yajra\DataTables\DataTables;
use App\Teachers;
use App\Material;


class SchoolDistrictController extends Controller
{

    /**
     * SchoolDistrictController constructor.
     */
    public function __construct()
    {
        $this->middleware('district');
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('schooldistrict.dashboard',compact('totalView','totalShare'));
    }

    /**
     * Dashboard view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        $users = new User();
        $totalUser = $users->getSchoolDistrictUsers();
        $school = new School();
        $totalShare = $school->shareMaterialStatisticBySchoolDistrict();
        $totalView = $school->viewMaterialStatisticBySchoolDistrict();
        return view('schooldistrict.dashboard', compact('totalUser', 'totalView', 'totalShare', 'totalCount'));
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
        return view(generateUrlPrefix() . ".profile", compact('userDetail', 'schoolsList', 'user_schools', 'rolesList', 'my_schools'));
    }

    /**
     * Update Profile data
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
     * Display the view of the school list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function schoolslistview()
    {
        return view('schooldistrict.schoolslist');
    }

    /**
     * Collect school listing to show on school listing page
     * @return mixed
     */
    public function schoolslist()
    {
        $school = new School();
        $list = $school->getSchoolListBySchoolDistrict();
        return Datatables::of($list)->make(true);
    }

    /**
     * Display Teachers View
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function teacherslistview()
    {
        return view('schooldistrict.teacherslist');
    }

    /**
     * Collect school listing to show on school listing page
     * @return mixed
     */
    public function teacherslist()
    {
        $school = new School();
        $teacherlist = $school->getTeachersListBySchools();
        return Datatables::of($teacherlist)->make(true);
    }

    /**
     * Display students list
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function studentslistview()
    {
        return view('schooldistrict.studentslist');
    }

    /**
     * retrive students list
     * @return mixed
     */
    public function studentslist()
    {
        $school = new School();
        $studentlist = $school->getStudentsListBySchools();
        return Datatables::of($studentlist)->make(true);
    }

    /**
     * Display view of Materilas Reports Class wise
     */
    public function materilasreport()
    {
        return view('schooldistrict.materialslist');
    }

    /**
     * Materials list
     * @return mixed
     */
    public function materilaslist()
    {
        $school = new School();
        $materilaslist = $school->getSharedMaterialsListBySchoolsClasses();
        return Datatables::of($materilaslist)->make(true);
    }
}
