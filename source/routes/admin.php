<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$locale = Request::segment(2);

if (in_array($locale, config('language.available_locales'),true)) {
    \App::setLocale($locale);
} else {
    $locale = "";
}


Route::group(array('prefix' => $locale), function(){

    Route::get('userprofile/{filename}', function ($filename)
    {
        $path = storage_path() . '/app/userprofile/' . $filename;

        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Route::get('/','AdminController@getLogin')->middleware('adminauth');
    //Route::get('/','AdminController@getLogin');
    //Route::get('/login','AdminController@getLogin');
    //Route::post('/login','AdminController@postLogin'); adminauth
    Route::get('/logout', 'AdminController@getLogout');

});


Route::group(['prefix' => $locale,'middleware'=>'adminauth'],function() {

        Route::post('/changepassword','DashboardController@changePassword');

        Route::get('/dashboard', 'DashboardController@index');

        Route::get('/users', 'UserController@index');
        Route::get('/users/create', 'UserController@create');
        Route::post('/users/create', 'UserController@store');
        Route::get('/users/{id}/edit', 'UserController@edit');
        Route::post('/users/{id}/edit', 'UserController@update');
        Route::get('/users/{id}/destroy', 'UserController@destroy');
        Route::get('/users/{id}/restore', 'UserController@restore');
        Route::get('/userslist', 'UserController@getData');
        Route::get('/zipvalidate/{zip}/{country}', 'UserController@zipValidate' );


        Route::get('/userrole', 'UserroleController@index');
        Route::get('/userrole/add', 'UserroleController@create');
        Route::post('/userrole/add', 'UserroleController@store');
        Route::get('/userrole/{id}/edit', 'UserroleController@edit');
        Route::post('/userrole/{id}/edit', 'UserroleController@update');
        Route::get('/userrole/{id}/delete', 'UserroleController@destroy');
        Route::get('/userrole/{id}/restore', 'UserroleController@restore');
        Route::get('/usersrolelistajax', 'UserroleController@getDataAjax');

        // This Is For Get user Role Base On Country Selection
        Route::get('/userrolelist/{country}/{roleid}', 'UserroleController@getListAjax');

        //Route::resource('schools', 'SchoolController');
        Route::get('/schools', 'SchoolController@index');
        Route::get('/schools/create', 'SchoolController@create');
        Route::post('/schools/create', 'SchoolController@store');
        Route::get('/schools/{id}/edit', 'SchoolController@edit');
        Route::post('/schools/{id}/edit', 'SchoolController@update');
        Route::get('/schools/{id}/delete', 'SchoolController@destroy');
        Route::get('/schools/{id}/restore', 'SchoolController@restore');
        Route::get('/schoollist', 'SchoolController@schoolList');

        Route::get('/classes', 'ClassesController@index');
        Route::get('/classes/create', 'ClassesController@create');
        Route::post('/classes/create', 'ClassesController@store');
        Route::get('/classes/{id}/edit', 'ClassesController@edit');
        Route::post('/classes/{id}/edit', 'ClassesController@update');
        Route::get('/classes/{id}/delete', 'ClassesController@destroy');
        Route::get('/classes/{id}/restore', 'ClassesController@restore');
        Route::get('/classlist', 'ClassesController@classlist');


        Route::get('/materials', 'MaterialsController@index');
        Route::get('/materialslist', 'MaterialsController@getDataAjax');

        Route::get('/materials/create', 'MaterialsController@create');
        Route::post('/materials/create', 'MaterialsController@store');

        Route::get('/materials/{id}/edit', 'MaterialsController@edit');
        Route::post('/materials/{id}/edit', 'MaterialsController@update');

        Route::get('/materials/{id}/delete', 'MaterialsController@destroy');
        Route::get('/materials/{id}/restore', 'MaterialsController@restoreMaterial');

        Route::get('/materials/category', 'MaterialsCategoriesController@index');
        Route::get('/materials/{id}/addcategory','MaterialsCategoriesController@loadModal');
        Route::post('/materials/addcategory','MaterialsCategoriesController@store');



        Route::get('/schools/teachers', 'TeachersController@index');
        Route::get('/schools/teacherslist', 'TeachersController@showTeachers');
        Route::get('/schools/teachers/create', 'TeachersController@create');
        Route::post('/schools/teachers/create','TeachersController@store');
        Route::get('/schools/teachers/{id}/edit', 'TeachersController@edit');
        Route::post('/schools/teachers/{id}/edit', 'TeachersController@update');

        Route::get('/schools/students', 'StudentsController@index');
        Route::get('/schools/studentlist', 'StudentsController@showStudents');
        Route::get('/schools/students/create', 'StudentsController@create');
        Route::post('/schools/students/create','StudentsController@store');
        Route::get('/schools/students/{id}/edit', 'StudentsController@edit');
        Route::post('/schools/students/{id}/edit', 'StudentsController@update');

});

