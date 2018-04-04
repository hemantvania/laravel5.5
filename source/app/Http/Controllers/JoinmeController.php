<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Settings;

class JoinmeController extends Controller
{
    /**
     * Start Meeeting Handler
     */
    public function startMeetingHandler()
    {
        Log::info('Join me Meeting Have Been Started: ');
    }

    /**
     * End Meeting Handler
     */
    public function endMeetingHandler()
    {
        Log::info('Join me Meeting Have Been Ended: ');
    }

    /**
     * Call Back Handler
     */
    public function callback()
    {

    }

    /**
     * Get Token from Join me
     */
    public function getToken()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://secure.join.me/api/public/v1/auth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "client_id=qnmeg8hsztxdtzvd5scpc44n&client_secret=3URj2VRCbb&code=su7rzn2jc5psb4suarjd4ytf&redirect_uri=http%3A%2F%2F10.0.2.167%3A8082%2Fcallback&grant_type=authorization_code",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "postman-token: 317423b5-f1e8-7fe2-5e06-e1372b36a1f5"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }

    }

    /**
     * get token expired time
     */
    public function getTokenExpireTime()
    {

        //https://secure.join.me/api/public/v1/auth/tokenInfo?access_token={access_token}
        $curl = curl_init();
        $heders = array();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://secure.join.me/api/public/v1/auth/tokenInfo?access_token=b2v5czkj9tz2q7x8bj9w5zxf",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    /**
     * refresh token methods
     */
    public function refreshtoken()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://secure.join.me/api/public/v1/auth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "client_id=qnmeg8hsztxdtzvd5scpc44n&client_secret=3URj2VRCbb&refresh_token=f8gvmxfq8yrzpv94nx9vcztc&grant_type=refresh_token",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "postman-token: b2b9cf78-2f25-501e-ce53-7aaf1db1846a"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    /**
     * Update the key setting of site
     * @param $key
     * @param $value
     */
    public function updateSettings($key,$value) {
        $objSettings = new Settings();
        $dbkeys = $objSettings->getSettingKey($key);
        if(!empty($dbkeys)){
            $objSettings->updateKey($key,$value);
        } else {
            $objSettings->insertKey($key,$value);
        }
    }
}
