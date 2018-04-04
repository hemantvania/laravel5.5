<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('zip_validate', function($attribute, $value, $parameters, $validator) {
            if(isset($parameters[0])){
                $country = $parameters[0];
            }else{
                $country = "1"; //$country = "Finland";
            }

                $zipCodes=array(
                "US"=>"^\d{5}([\-]?\d{4})?$",
                "UK"=>"^(GIR|[A-Z]\d[A-Z\d]??|[A-Z]{2}\d[A-Z\d]??)[ ]??(\d[A-Z]{2})$",
                "DE"=>"\b((?:0[1-46-9]\d{3})|(?:[1-357-9]\d{4})|(?:[4][0-24-9]\d{3})|(?:[6][013-9]\d{3}))\b",
                "CA"=>"^([ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ])\ {0,1}(\d[ABCEGHJKLMNPRSTVWXYZ]\d)$",
                "FR"=>"^(F-)?((2[A|B])|[0-9]{2})[0-9]{3}$",
                "IT"=>"^(V-|I-)?[0-9]{5}$",
                "AU"=>"^(0[289][0-9]{2})|([1345689][0-9]{3})|(2[0-8][0-9]{2})|(290[0-9])|(291[0-4])|(7[0-4][0-9]{2})|(7[8-9][0-9]{2})$",
                "NL"=>"^[1-9][0-9]{3}\s?([a-zA-Z]{2})?$",
                "ES"=>"^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$",
                "DK"=>"^([D-d][K-k])?( |-)?[1-9]{1}[0-9]{3}$",
                "SE"=>"^(s-|S-){0,1}[0-9]{3}\s?[0-9]{2}$",
                "BE"=>"^[1-9]{1}[0-9]{3}$",
                "1"=>"^(?:FI)*(\d{5})$", // Finland
                "2"=> "^(?:SE)*(\d{5})$" // Sweden
            );

            if ($zipCodes[$country]) {

                if (!preg_match("/".$zipCodes[$country]."/i",$value)){
                    return false;

                } else {
                    return true;
                }

            } else {

                //Validation not available

            }
        });


        /**
         * This is use for check is valid url
         */
        \Validator::extend('url_validate', function($attribute, $value, $parameters, $validator) {

            if(!empty($value)){

                if(filter_var($value,FILTER_VALIDATE_URL)){
                    return true;
                } else {
                    return false;
                }
            } else {
                if(!empty($parameters[0]) && $parameters[0] == "Link"){
                    return false;
                } else{
                    return true;
                }
            }
        });


        /**
         *
         */
        \Validator::extend('content_update', function($attribute, $value, $parameters, $validator) {

            if(!empty($parameters[0]) && $parameters[0] != "Link"){
                if(!empty($parameters[1])){
                    return true;
                } else {
                    return false;
                }
            } else{
                return true;
            }

        });


        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
