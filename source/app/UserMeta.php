<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class UserMeta extends Model
{
    use SoftDeletes;

    protected $table = "user_metas";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userId', 'phone', 'profileimage', 'addressline1', 'addressline2', 'ssn', 'city', 'country', 'zip', 'gender', 'enable_share_screen', 'default_school','language','user_preference'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Building relation with User Model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /**
     * Building relation with Countries Model
     * @return bool
     */
    public function country()
    {
        return $this->belongsTo('App\Countries', 'country');
    }

    /**
     * Function is use for update usermeta detail
     * @param $userData
     * @param null $id
     * @return $this|bool|Model
     */
    public function updateUserData($userData, $id = NULL)
    {
        if (!empty($userData)) {
            $data = $userData;

            if ($id == NULL)
                return $this->createUserMeta($data);

            $usermeta = self::where('userId', $id)->first();

            if (!$usermeta)
                return false;

            if (array_key_exists('phone', $data)) $usermeta->phone = $data['phone'];
            if (array_key_exists('addressline1', $data)) $usermeta->addressline1 = $data['addressline1'];
            if (array_key_exists('addressline2', $data)) $usermeta->addressline2 = $data['addressline2'];
            if (array_key_exists('ssn', $data)) $usermeta->ssn = $data['ssn'];
            if (array_key_exists('gender', $data)) $usermeta->gender = $data['gender'];
            if (array_key_exists('city', $data)) $usermeta->city = $data['city'];
            if (array_key_exists('state', $data)) $usermeta->state = $data['state'];
            if (array_key_exists('zip', $data)) $usermeta->zip = $data['zip'];
            if (array_key_exists('country', $data)) $usermeta->country = $data['country'];
            if (array_key_exists('enable_share_screen', $data)) $usermeta->enable_share_screen = !empty($data['enable_share_screen']) ? $data['enable_share_screen'] : 0;
            if (array_key_exists('remove_logo', $data)) $usermeta->profileimage = $data['remove_logo'];
            if (array_key_exists('profileimage', $data)) $usermeta->profileimage = $data['profileimage'];

            // only portal admin has option to set default school for teachers
            if (array_key_exists('default_school', $data)) $usermeta->default_school = $data['default_school'];
            if (array_key_exists('default_language', $data)) $usermeta->language = $data['default_language'];
            if (array_key_exists('user_preference',$data)) $usermeta->language = $data['default_language'];

            if ($usermeta->update()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Creating User Meta For All Users
     * @param $data
     * @return $this|Model
     */
    public function createUserMeta($data)
    {
        return $id = self::insertGetId(
            [
                'userId'                => $data['userid'],
                'phone'                 => $data['phone'],
                'profileimage'          => $data['profileimage'],
                'addressline1'          => $data['addressline1'],
                'addressline2'          => $data['addressline2'],
                'city'                  => $data['city'],
                'state'                 => $data['state'],
                'zip'                   => $data['zip'],
                'country'               => $data['country'],
                'ssn'                   => $data['ssn'],
                'gender'                => $data['gender'],
                'default_school'        => $data['default_school'],
                'enable_share_screen'   => $data['enable_share_screen'],
                'language'              => $data['default_language'],
                'user_preference'       => $data['default_language'],
                'created_at'            => new \DateTime(),
                'updated_at'            => new \DateTime()
            ]
        );
    }

    /**
     * Update Users Meta By User Id
     * @param $data
     * @param $userid
     * @return bool
     */
    public function UpdateUserMeta($data, $userid)
    {
        return self::where('userId', $userid)
            ->update(
                [
                    'phone'                 => $data['phone'],
                    'profileimage'          => $data['profileimage'],
                    'addressline1'          => $data['addressline1'],
                    'addressline2'          => $data['addressline2'],
                    'city'                  => $data['city'],
                    'state'                 => $data['state'],
                    'zip'                   => $data['zip'],
                    'country'               => $data['country'],
                    'ssn'                   => $data['ssn'],
                    'gender'                => $data['gender'],
                    'default_school'        => $data['default_school'],
                    'enable_share_screen'   => $data['enable_share_screen'],
                    'language'              => $data['default_language'],
                    'user_preference'       => $data['default_language']
                ]
            );
    }

    /**
     * Get the User Meta based on user id
     * @param $userid
     * @return Model|null|static
     */
    public function getUserMeta($userid)
    {
        return self::where('userId', $userid)->first();
    }

    /**
     * Set User Prefferrence
     * @param $language
     * @return bool
     */
    public function updateUserPrefferrence($language){
        $authID = Auth::user()->id;
        return self::where('userid',$authID)
            ->update([
                'user_preference' => $language,
                'language' => $language
            ]);
    }

    /**
     * Get the User Selected Prefferrence
     * @return Model|null|static
     */
    public function getUserPrefferrence(){
        $authID = Auth::user()->id;
        return self::where('userId', $authID)
            //->select('user_preference')
            ->select('language')
            ->first();
    }


}
