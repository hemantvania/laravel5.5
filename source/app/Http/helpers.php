<?php
/**
 * Set Active Url in menu
 * @param $path
 * @return string
 */
function setActive($path)
{
    if (is_array($path)) {
        $active = false;
        foreach ($path as $data) {
            if (Request::is($data)) {
                $active = true;
                continue;
            }
        }
        return $active ? ' active ' : '';
    } else {
        return Request::is($path) ? ' active ' : '';
    }
}

/**
 * Set Active Prefix
 * @param $path
 * @return string
 */
function setActivePrifix($path)
{
    if (is_array($path)) {
        $active = false;
        foreach ($path as $data) {
            if (Request::is($data . '*')) {
                $active = true;
                continue;
            }
        }
        return $active ? ' active ' : '';
    } else {
        return Request::is($path . '*') ? ' active ' : '';
    }
}

/**
 * This function is used for getting language key and generate url based on it
 * @param $key , $url = null
 * @return mixed|string
 */
function generateLangugeUrl($key, $url = null)
{

    if ($url == null)
        $url = Request::URL();

    $urlarray = parse_url($url);
    $newurl = $urlarray['scheme'] . '://' . $urlarray['host'];
    if (isset($urlarray['port'])) {
        $newurl = $newurl . ':' . $urlarray['port'];
    }

    if (strpos($url, '/fi') !== false) {
        return str_replace('/fi', '/' . $key, $url);
    } else if (strpos($url, '/en') !== false) {
        return str_replace('/en', '/' . $key, $url);
    } else if (strpos($url, '/sv') !== false) {
        return str_replace('/sv', '/' . $key, $url);
    } else {
        if (isset($urlarray['path'])) {
            $newurl = $newurl . '/' . $key . $urlarray['path'];
        } else {
            $newurl = $newurl . '/' . $key;
        }
        return $newurl;
    }
}

/**
 * This function is used for getting language key and generate url based on it for Super Admin (Admin Section)
 * @param $key , $url = null
 * @return mixed|string
 */
function generateLangugeUrlAdmin($key, $url = null)
{

    if ($url == null)
        echo $url = Request::URL();

    $urlarray = parse_url($url);

    $newurl = $urlarray['scheme'] . '://' . $urlarray['host'];
    if (isset($urlarray['port'])) {
        $newurl = $newurl . ':' . $urlarray['port'];
    }

    if (strpos($url, '/fi') !== false) {
        return str_replace('/fi', '/' . $key, $url);
    } else if (strpos($url, '/en') !== false) {
        return str_replace('/en', '/' . $key, $url);
    } else if (strpos($url, '/sv') !== false) {
        return str_replace('/sv', '/' . $key, $url);
    } else {

        if (isset($urlarray['path'])) {
            $newurl = $newurl . '/admin/' . $key . $urlarray['path'];
        } else {
            $newurl = $newurl . '/admin/' . $key;
        }


        return $newurl;
    }
}

/**
 * This function is used for generating the dashboard link and set to logo
 * @param string $roleid
 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
 */
function generateDashboardLink($roleid = '')
{
    switch ($roleid) {
        case '1':
            return generateLangugeUrlAdmin(App::getLocale(), url('/dashboard'));
            break;
        case '2':
            return generateLangugeUrl(App::getLocale(), url('/teacher/dashboard'));
            break;
        case '3':
            return generateLangugeUrl(App::getLocale(), url('/home'));
            break;
        case '4':
            return generateLangugeUrl(App::getLocale(), url('/schooldistrict/dashboard'));
            break;
        case '5':
            return generateLangugeUrl(App::getLocale(), url('/portaladmin/dashboard'));
            break;
        case '6':
            return generateLangugeUrl(App::getLocale(), url('/school/dashboard'));
            break;
        default:
            return generateLangugeUrl(App::getLocale(), url('/home'));
    }
}

/**
 * Get Cutent type list to upload material
 * @return array
 */
function getUploadContentTypes()
{
    return array('Video', 'Pdf', 'Image', 'Link');
}

/**
 * Get URL
 * @return url prefix as per auth user
 */
function generateUrlPrefix()
{
    $userRole = \Auth::user()->userrole;
    $prifix = "";
    if ($userRole == 2) {
        $prifix = 'teacher';
    } elseif ($userRole == 4) {
        $prifix = 'schooldistrict';
    } elseif ($userRole == 5) {
        $prifix = 'portaladmin';
    } elseif ($userRole == 6) {
        $prifix = 'school';
    }
    return $prifix;
}

/**
 * Print array to check data
 * @param $array
 * @param bool $isExit
 */
function prt($array, $isExit = false)
{
    if (!empty($array)) {
        echo "<pre>";
        print_r($array);
    }
    if ($isExit) {
        die();
    }
}

/**
 * Will return string with given limit. If tring length more than limit it will add ... at the end
 * @param $str
 * @param int $limits
 * @return string
 */
function setStringLength($str, $limits = 20)
{
    if (!empty($str)) {
        return str_limit($str, $limit = $limits, $end = '...');
    } else {
        return "";
    }
}