<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\School;
use Input;
use Redirect;
use App\Http\Requests\ClassAddAdmin;
use App\Http\Requests\ClassUpdateAdmin;
use App\Classes;
use App\EducationType;
use Yajra\DataTables\DataTables;


class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.classes.index');
    }

    /**
     * Display listing
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
            $url = url("/admin/classes/" . $classes->id . "/edit");
            $output .= '<div class="btn-group">';
            $output .= '<a href="' . $url . '" class="btn btn-primary" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i ></a>';
            $output .= '</div>';
            $output .= '&nbsp;';
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $classes->id . '" class="remove-class btn btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o" ></i ></a>';
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
        $edutcationType = new EducationType();
        $edutcationTypeList = $edutcationType->getTypes();
        $userSchoolId = Auth::user()->userMeta->schoolId;
        $teachers = User::where([['users.userrole', '=', '2'], ['user_metas.schoolId', '=', $userSchoolId]])
            ->join('user_metas', 'user_metas.userId', '=', 'users.id')->get();
        return view("admin.classes.add", compact('schoolsList', 'edutcationTypeList', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     * @param ClassAddAdmin $request
     * @return mixed
     */
    public function store(ClassAddAdmin $request)
    {
        $class = new Classes();
        $data = $request->all();
        $create = $class->addClassAdmin($request);
        if ($create) {
            return Redirect::to('admin/classes')->with('message', __('adminclasses.addsuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to('admin/classes/create')->with('message', __('adminclasses.failure'))->with('class', 'alert-danger');
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
        $class = new Classes();
        $classDetail = $class->getClassById($id);
        $school = new School();
        $schoolsList = $school->getList();
        $edutcationType = new EducationType();
        $edutcationTypeList = $edutcationType->getTypes();
        return view("admin.classes.add", compact('classDetail', 'schoolsList', 'edutcationTypeList'));
    }

    /**
     * Update the specified resource in storage.
     * @param ClassUpdateAdmin $request
     * @param $id
     * @return mixed
     */
    public function update(ClassUpdateAdmin $request, $id)
    {
        $class = new Classes();
        $updateClass = $class->classUpdate($request, $id);
        if ($updateClass) {
            return Redirect::to('admin/classes')->with('message', __('adminclasses.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to('admin/classes/' . $id . '/edit')->with('message', __('adminclasses.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
    public function restore($id)
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
}
