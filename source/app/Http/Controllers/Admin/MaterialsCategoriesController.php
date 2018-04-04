<?php

namespace App\Http\Controllers\Admin;

use App\MaterialCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialsCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catList = MaterialCategory::getCategories();
        return view("admin.materialcategory.index", compact('catList'));
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
        $categoryName = $request->get('catName');
        $parentCatId = $request->get('parentId');
        $isActive = 1;
        $objMaterialCategory = new MaterialCategory();
        $store = $objMaterialCategory->createCategory($categoryName, $parentCatId, $isActive);
        if ($store) {
            return response()->json(["status" => true, 'message' => __('adminmaerialcat.addsuccess')]);
        } else {
            return response()->json(["status" => false, 'message' => __('adminmaerialcat.failure')]);
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
     * Function is create for render add cateogry modal popup
     * @param $id
     * @return string
     */
    public function loadModal($id)
    {
        return view('admin.materialcategory.categorymodal')->with(compact('id'))->render();
    }

    /**
     * Return list of all child category for specific category from id
     * @param $id
     * @return $this
     */
    public static function getChildCategory($id)
    {
        $objMaterialCategory = new MaterialCategory();
        return $objMaterialCategory->hasChildCategory($id);
    }
}
