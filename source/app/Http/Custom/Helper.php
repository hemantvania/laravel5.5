<?php

namespace App\Http\Custom;

use Illuminate\Support\Facades\Redis;
use App\User;
use Lang;
use App\Http\Middleware\Language;
use App\Settings;

class Helper
{
    /**
     * Get Logged in user from redis
     * @param null $cursor
     * @param array $allResults
     * @return array
     */
    public static function loggedUsers($cursor = null, $allResults = array())
    {
        // Zero means full iteration
        if ($cursor === "0") {
            // Get rid of duplicated values caused by redis scan limitations.
            $allResults = array_unique($allResults);
            // Setting users array
            $users = array();
            // Looping through all results. Inserting each logged user into array.
            foreach ($allResults as $result) {
                $users[] = User::where('id', Redis::Get($result))->first();
            }
            // Removing duplicate items. (If user has logged in using more than one machine)
            $users = array_unique($users);
            return $users;
        }
        // No $cursor means init
        if ($cursor === null) {
            $cursor = "0";
        }
        // The call
        $result = Redis::command('SCAN', [$cursor, 'match', 'vdeskusers:*']);
        //$keys = Redis::keys('vdeskusers:*');
        // Append results to array
        $allResults = array_merge($allResults, $result[1]);
        // Recursive call until cursor is 0
        return self::loggedUsers($result[0], $allResults);
    }

    /**
     * Join me Auth Call back function
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    function getJoinMeAccess()
    {
        $curl = curl_init();
        $heders = array();
        $objSettings = new Settings();
        $tokendata = $objSettings->getSettingKey('joinmetoken');
        if(!empty($tokendata)) {
            $joime_token = $tokendata->value;

            if(!empty($joime_token)) {

                $heders = array(
                    "authorization: Bearer ".$joime_token,
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded",
                    "postman-token: 69681313-5559-202e-8184-038d70bb8118"
                );
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.join.me/v1/meetings/start",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_SSL_VERIFYPEER => FALSE,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "viewerMode=headless&viewerAppDetection=false",
                    CURLOPT_HTTPHEADER => $heders
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                    return response()->json([
                        'status' => false,
                        'message' => $err
                    ]);
                } else {
                    return $response;
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('general.failure')
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => __('general.failure')
            ]);
        }


    }
}

?>