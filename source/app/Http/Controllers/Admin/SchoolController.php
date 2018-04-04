<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\School;
use Input;
use Redirect;
use App\Http\Requests\SchoolAdmin;
use App\Http\Requests\SchoolAdminUpdate;
use Yajra\DataTables\DataTables;
use App\Countries;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.school.index");
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function schoolList()
    {
        $school = new School();
        $list = $school->getList();
        return Datatables::of($list)
            ->addColumn('action', function ($list) {
                return $this->generateAction($list);
            })
            ->make(true);
    }

    /**
     * Process datatables ajax request Generate Action Field.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateAction($school)
    {

        $output = "";
        if ($school->deleted_at) {
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $school->id . '" data-toggle="tooltip" title="Restore" class="restore-school btn btn-primary"><i class="fa fa-undo"></i></a>';
            $output .= '</div>';
        } else {
            $url = url("/admin/schools/" . $school->id . "/edit");
            $output .= '<div class="btn-group">';
            $output .= '<a href="' . $url . '" class="btn btn-primary" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i ></a>';
            $output .= '</div>';
            $output .= '&nbsp;';
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $school->id . '" class="remove-school btn btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o" ></i ></a>';
            $output .= '</div>';
        }
        return $output;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $schoolDisctirict = $user->getSchoolDistrict();
        $countries = new Countries();
        $countrieList = $countries->getCountryList();

        return view("admin.school.add", compact('schoolDisctirict', 'countrieList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolAdmin $request)
    {
        $school = new School();
        $storeSchool = $school->storeSchool($request);
        if ($storeSchool) {
            return Redirect::to('admin/schools')->with('message', __('adminschool.addsuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to('admin/schools/create')->with('message', __('adminschool.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school = new School();
        $schoolDetail = $school->getSchoolById($id);
        $user = new User();
        $schoolDisctirict = $user->getSchoolDistrict();
        $countries = new Countries();
        $countrieList = $countries->getCountryList();

        return view("admin.school.add", compact('schoolDetail', 'schoolDisctirict', 'countrieList'));
    }

    /**
     * Update the specified resource in storage.
     * @param SchoolAdminUpdate $request
     * @param $id
     * @return mixed
     */
    public function update(SchoolAdminUpdate $request, $id)
    {
        $school = new School();
        $updateSchool = $school->schoolUpdate($request, $id);
        if ($updateSchool) {
            return Redirect::to('admin/schools')->with('message', __('adminschool.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to('admin/schools/' . $id . '/edit')->with('message', __('adminschool.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $school = new School();
        $checkRecord = $school->checkRecordExist($id);
        if ($checkRecord) {
            $schoolDelete = $school->schoolDelete($id);
            if ($schoolDelete) {
                return response()->json([
                    'status' => true,
                    'message' => __('adminschool.deletesuccess')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('adminschool.failure')
                ]);

            }
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminschool.norecordsfound')
            ]);

        }
    }


    /**
     * Restore the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $school = new School();
        $school = $school->restoreRecord($id);
        if ($school) {
            return response()->json([
                'status' => true,
                'message' => __('adminuserrole.restoresuccess')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminuserrole.failure')
            ]);
        }
    }
}
