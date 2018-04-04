<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Session;

use Redirect;

class LanguageLocalizationController extends Controller
{
    public function index($lang)
    {
        $langs = ['en', 'fi'];
        if (in_array($lang, $langs)) {
            Session::put('lang', $lang);
            return Redirect::back();
        }

    }
}
