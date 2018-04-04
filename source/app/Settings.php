<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'key', 'value',
    ];

    /**
     * get the settings key
     * @param $key
     * @return Model|null|static
     */
    public function getSettingKey($key){
        return self::where('key',$key)
            ->select('value')
            ->first();
    }

    /**
     * Update Key Value
     * @param $key
     * @param $value
     * @return bool
     */
    public function updateKey($key,$value){
        return self::where('key',$key)
            ->update([
                'value' => $value
            ]);
    }

    /**
     * Inserting new key settings
     * @param $key
     * @param $value
     * @return bool
     */
    public function insertKey($key,$value){
        return self::insert(
            [
                'key' => $key,
                'value' => $value,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]
        );
    }


}
