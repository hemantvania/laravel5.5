<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Thread extends Model
{
    use DatabaseTransactions;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner'
    ];

    /**
     * Insert new id
     * @return int
     */
    public function createThread($authid)
    {
        return self::insertGetId(
            [
                'owner' => $authid,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]
        );
    }
}
