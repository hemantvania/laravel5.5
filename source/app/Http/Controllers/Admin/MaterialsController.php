<?php

namespace App\Http\Controllers\Admin;

use App\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\MaterialCategory;
use App\Http\Requests\ContentAddRequest;
use App\Http\Requests\ContentUpdateRequest;
use Redirect;

class MaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.materials.index");
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materialCategory = new MaterialCategory();
        $materialCategories = $materialCategory->getCategories();
        return view("admin.materials.add-materials", compact('materialCategories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param ContentAddRequest $request
     * @return mixed
     */
    public function store(ContentAddRequest $request)
    {
        $create = Material::storeMaterial($request);
        if ($create) {
            return Redirect::to('admin/materials')->with('message', __('adminmaterial.addsuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to('admin/materials/create')->with('message', __('adminmaterial.failure'))->with('class', 'alert-danger');
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
        $getMaterial = Material::geMaterialById($id);
        $materialCategory = new MaterialCategory();
        $materialCategories = $materialCategory->getCategories();
        return view('admin.materials.add-materials', compact('getMaterial', 'materialCategories'));
    }

    /**
     * Update the specified resource in storage.
     * @param ContentUpdateRequest $request
     * @param $id
     * @return mixed
     */
    public function update(ContentUpdateRequest $request, $id)
    {
        $update = Material::updateMaterialDetail($request, $id);
        if ($update) {
            return Redirect::to('admin/materials')->with('message', __('adminmaterial.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to('admin/materials/' . $id . '/edit')->with('message', __('adminmaterial.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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

    /**
     * Function is use for retrun material list on index
     * @return mixed
     */
    public function getDataAjax()
    {
        $materials = Material::getAllMaterialList();
        return Datatables::of($materials)
            ->addColumn('action', function ($material) {
                return $this->generateAction($material);
            })
            ->make(true);
    }

    /**
     * Process datatables ajax request Generate Action Field.
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateAction($material)
    {

        $output = "";
        if ($material->deleted_at) {
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $material->id . '" data-toggle="tooltip" title="Restore" class="restore-contents btn btn-primary"><i class="fa fa-undo"></i></a>';
            $output .= '</div>';
        } else {
            $editUrl = url("/admin/materials/" . $material->id . "/edit");
            $output .= '<div class="btn-group">';
            $output .= '<a href="' . $editUrl . '" data-toggle="tooltip" title="Edit" class="btn btn-primary"><i class="fa fa-edit"></i></a>';
            $output .= '</div>';
            $output .= '&nbsp;';
            $output .= '<div class="btn-group">';
            $output .= ' <a href="javascript:void(0);" data-index="' . $material->id . '" data-toggle="tooltip" title="Delete" class="remove-contents btn btn-danger"><i class="fa fa-trash-o" ></i ></a>';
            $output .= '</div>';
        }
        return $output;
    }
}
