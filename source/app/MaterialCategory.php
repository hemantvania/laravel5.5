<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialCategory extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'material_categories';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'categoryName', 'parentCatId', 'isActive'
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Function create for check category has child category and if yes return list
     * @param $id
     * @return mixed
     */
    public function hasChildCategory($id)
    {
        return self::where('parentCatId', $id)->withTrashed()->get();
    }

    /**
     * Function create for get list of all categories
     * @return mixed
     */
    public function getCategories()
    {
        return self::where('parentCatId', 0)->withTrashed()->get();
    }

    /**
     * Function create for store material category in material_categories table DB
     * @param $categoryName
     * @param $parentCatId
     * @param $isActive
     * @return bool
     */
    public function createCategory($categoryName, $parentCatId, $isActive)
    {
        $category = new MaterialCategory();
        $category->categoryName = $categoryName;
        $category->parentCatId = $parentCatId;
        $category->isActive = $isActive;
        if ($category->save()) {
            return true;
        } else {
            return false;
        }
    }
}
