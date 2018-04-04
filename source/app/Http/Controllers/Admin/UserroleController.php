<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Userrole;
use Input;
use Redirect;
use App\Http\Requests\UserRoleUpdate;
use App\Countries;
use App\RolesCountry;
use Yajra\DataTables\DataTables;
use Auth;

class UserroleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.userrole.index");
    }

    /**
     * Function is use for get records from userole table for ajax load records
     * @return mixed
     */
    public function getDataAjax()
    {
        $userroles = Userrole::getList();
        return Datatables::of($userroles)
            ->addColumn('action', function ($userrole) {
                return $this->generateAction($userrole);
            })
            ->editColumn('isactive', function ($userrole) {
                if ($userrole->isactive == 1) {
                    return __('adminuserrole.active');
                } else {
                    return __('adminuserrole.deactive');
                }
            })
            ->make(true);
    }

    /**
     * Process datatables ajax request Generate Action Field.
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateAction($userrole)
    {
        $output = "";
        if ($userrole->deleted_at) {
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $userrole->id . '" data-toggle="tooltip" title="Restore" class="restore-userrole btn btn-primary"><i class="fa fa-undo"></i></a>';
            $output .= '</div>';
        } else {
            $editUrl = url("/admin/userrole/" . $userrole->id . "/edit");
            $output .= '<div class="btn-group">';
            $output .= '<a href="' . $editUrl . '" data-toggle="tooltip" title="Edit" class="btn btn-primary"><i class="fa fa-edit"></i></a>';
            $output .= '</div>';
            $output .= '&nbsp;';
            $output .= '<div class="btn-group">';
            $output .= ' <a href="javascript:void(0);" data-index="' . $userrole->id . '" data-toggle="tooltip" title="Delete" class="remove-userrole btn btn-danger"><i class="fa fa-trash-o" ></i ></a>';
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
        $countries = new Countries();
        $countrieList = $countries->getCountryList();
        return view("admin.userrole.add", compact('countrieList'));
    }

    /**
     * Store a newly created resource in storage.
     * @param UserRoleUpdate $request
     * @return mixed
     */
    public function store(UserRoleUpdate $request)
    {
        $rolename = $request->get('rolename');
        $isactive = $request->get('isactive');
        $countires = $request->get('countries');
        $userRole = new Userrole();
        $storeRecords = $userRole->storeRole($rolename, $isactive, $countires);
        if ($storeRecords) {
            return Redirect::to('admin/userrole')->with('message', __('adminuserrole.addsuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to('admin/userrole/add')->with('message', __('adminuserrole.failure'))->with('class', 'alert-danger');
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
        $userRole = new Userrole();
        $getRecords = $userRole->getUserroleById($id);
        $countries = new Countries();
        $countrieList = $countries->getCountryList();
        $rolesCountries = new RolesCountry();
        $countriesListEdit = $rolesCountries->roleCountiresById($id);
        return view("admin.userrole.add", compact('getRecords', 'countrieList', 'countriesListEdit'));
    }

    /**
     * Update the specified resource in storage.
     * @param UserRoleUpdate $request
     * @param $id
     * @return mixed
     */
    public function update(UserRoleUpdate $request, $id)
    {
        $rolename = $request->get('rolename');
        $isactive = $request->get('isactive');
        $countires = $request->get('countries');
        $userRole = new Userrole();
        $updateRoles = $userRole->updateRole($rolename, $isactive, $countires, $id);
        if ($updateRoles) {
            return Redirect::to('admin/userrole')->with('message', __('adminuserrole.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to('admin/userrole/".$id."/edit')->with('message', __('adminuserrole.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userRole = new Userrole();
        $checkRecord = $userRole->checkRecordExist($id);
        if ($checkRecord) {
            $userRole = $userRole->deleteUserrole($id);
            if ($userRole) {
                return response()->json([
                    'status' => true,
                    'message' => __('adminuserrole.deletesuccess')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('adminuserrole.failure')
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminuserrole.norecordsfound')
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
        $userRole = new Userrole();
        $userRole = $userRole->restoreRecord($id);
        if ($userRole) {
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

    /**
     * Function use for get role list by ajax base on country selection
     * @param $country
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListAjax($country, $roleid = "")
    {
        $roleCountry = new RolesCountry();
        $rolesList = $roleCountry->getRoleByCountry($country);
        $roleOption = "<option value=''>Select Role</option>";
        $authRole = Auth::user()->userrole;
        if (!empty($rolesList)) {
            foreach ($rolesList as $role) {
                $isSelected = (!empty($roleid) && $role->roleId == $roleid) ? 'selected="selected"' : "";
                if ($role->roleId != 1) {
                    if (($authRole == 5) && ($role->roleId == 2 || $role->roleId == 4)) {
                        $roleOption .= "<option value=" . $role->roleId . " " . $isSelected . " >$role->rolename</option>";
                    } elseif ($authRole != 5) {
                        $roleOption .= "<option value=" . $role->roleId . " " . $isSelected . " >$role->rolename</option>";
                    }
                }
            }
            return response()->json([
                'status' => true,
                'list' => $roleOption
            ]);
        } else {
            return response()->json([
                'status' => false,
                'list' => $roleOption
            ]);
        }
    }
}
