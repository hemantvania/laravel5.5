<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationType extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'education_types';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'educationName', 'active'
    ];

    /**
     * The attributes that should be mutated to dates.
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Building relation with classes model
     * @return mixed
     */
    public function classes()
    {
        return $this->hasMany(Classes::class)->withTrashed();
    }

    /**
     * Get All Education Types from table
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getTypes()
    {
        return $this->all();
    }


}
