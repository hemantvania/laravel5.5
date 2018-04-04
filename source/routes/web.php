<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Events\StartClass;
use Illuminate\Support\Facades\Auth;

$locale = Request::segment(1);

if (in_array($locale, config('language.available_locales'),true)) {
    \App::setLocale($locale);
} else {
    $locale = null;
}



/* Update active user time on browser event*/
Route::get('update-auth-activity','UserActivityUpdateController@AuthActivityUpdate');

// For Default User Student
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


    Route::get('contents/{filename}', function ($filename)
    {

        $path = storage_path() . '/app/contents/' . $filename;

        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Route::get('storage/{filename}', function ($filename)
    {
        $path = storage_path() . '/' . $filename;

        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Route::get('contentsicons/{filename}', function ($filename)
    {
        $path = storage_path() . '/app/contentsicons/' . $filename;

        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });


    Route::get('school-logo/{filename}', function ($filename)
    {
        $path = storage_path() . '/app/school-logo/' . $filename;

        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Auth::routes();

    Route::get('register', 'HomeController@index');

    Route::get('/otherlogin', 'OtherLoginController@showlogin')->name('OtherLogin');
    Route::post('/otherlogin', 'OtherLoginController@login')->name('OtherLoginSubmit');
   // Route::get('/logout', 'AdminController@getLogout');

    // For Student
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'HomeController@index')->name('home');
    Route::post('/profile/{id}/update','HomeController@updateProfile')->name('updateProfile');
    Route::post('/classcompleted', 'HomeController@classCompleted')->name('class-completed');
    Route::post('/classmaterials', 'HomeController@getClassMaterials')->name('class.Materials');
    Route::post('/openmessagebox','HomeController@checkThread')->name('openMessageBox');
    Route::post('/sendmessage', 'HomeController@sendMessage')->name('sendMessage');
    Route::post('/viewmessage', 'HomeController@viewMessages')->name('viewMessages');
    Route::post('viewmaterial', 'HomeController@addToViewedMaterial')->name('addToViewedMaterial');

    //getTocken

    Route::get('refreshtoken', 'JoinmeController@refreshtoken')->name('refreshtoken');
    Route::get('getTocken', 'JoinmeController@getTocken')->name('getTocken');
    Route::get('getTockenExptime', 'JoinmeController@getTokenExpireTime')->name('getTokenExpireTime');
    Route::get('callback', 'JoinmeController@callback')->name('callback');
    Route::get('meetingstarted', 'JoinmeController@startMeetingHandler')->name('startMeetingHandler');
    Route::get('meetingended', 'JoinmeController@endMeetingHandler')->name('endMeetingHandler');
    Route::get('/key/{id}/{value}/', 'JoinmeController@updateSettings')->name('joinme.updatesettings');

    Route::post('sharescreen','HomeController@shareScreen')->name('screenShare');

    // For Teacher
    Route::prefix('teacher')->group(function () {

        Route::get('/switchschool', 'TeacherController@switchschool')->name('teacher.schoolwsitch');
        Route::post('/switchschool', 'TeacherController@switchschoolupdate')->name('teacher.schoolwsitchsubmit');

        Route::get('/', 'TeacherController@index')->name('teacher.dashboard');
        Route::get('/dashboard', 'TeacherController@index')->name('teacher.dashboard');
        Route::get('/materiallist', 'TeacherController@materiallist')->name('teacher.list');
        Route::get('/studentslist', 'TeacherController@showStudents')->name('teacher.studentslist');
        Route::get('/students/add', 'TeacherController@createStudents')->name('teacher.studentadd');
        Route::post('/students/add','TeacherController@storeStudents')->name('teacher.studentsadd.submit');
        Route::get('/students/{id}/edit', 'TeacherController@editStudents')->name('teacher.studentedit');
        Route::post('/students/{id}/edit', 'TeacherController@updateStudents')->name('teacher.studenteditsubmit');
        Route::get('/students/{id}/destroy', 'TeacherController@studentDestroy')->name('teacher.studentdelete');
        Route::get('/students/{id}/restore', 'TeacherController@studentRestore')->name('teacher.studentrestore');
        //Assign to class

        Route::post('/students/assign','TeacherController@assignStudents')->name('teacher.studentassign');
        Route::post('/material/assign','TeacherController@assignMaterials')->name('teacher.materialsassign');
        Route::post('/desk/{id}','TeacherController@showDeskuser')->name('teacher.showdeskuser');
        Route::post('/dashboard/downloadmaterials','TeacherController@downloadMaterials')->name('teacher.downloadmaterials');
        Route::post('/contents/add','TeacherController@storeMaterial')->name('teacher.storematerials.submit');

        Route::get('contents/{filename}', function ($filename)
        {
            $path = storage_path() . '/app/contents/' . $filename;
            if(!File::exists($path)) abort(404);
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        });

        // edit profile
        Route::post('profile/{id}/update','TeacherController@updateProfile')->name('teacher.updateProfile');
        Route::post('materials/changestatus','TeacherController@changeMaterialStatus')->name('teacher.changeMaterialStatus');
        Route::post('startclass','TeacherController@startClass')->name('teacher.startClass');
        Route::post('onlinestudent','TeacherController@checkOnlineStudentsInClass')->name('teacher.checkOnlineStudentInClass');
        Route::get('notificationslist', 'TeacherController@getTeacherNotificationList')->name('teacher.notificationslist');
        Route::post('checkthread','TeacherController@checkThread')->name('teacher.checkthred');
        Route::post('sendmessage','TeacherController@sendMessage')->name('teacher.sendmessage');
        Route::post('pauseclass','TeacherController@pauseClass')->name('teacher.pauseclass');
        Route::post('stopclass','TeacherController@stopClass')->name('teacher.stopclass');
        Route::post('resumeclass','TeacherController@resumeClass')->name('teacher.resumeclass');
        Route::post('sharescreen','TeacherController@shareScreen')->name('teacher.screenShare');
        Route::post('managetouch','TeacherController@managetouch')->name('teacher.managetouch');
        Route::post('deletematerial','TeacherController@deleteMaterials')->name('teacher.deletematerials');


    });

    // For School
    Route::prefix('school')->group(function () {

        Route::get('/profile', 'SchoolController@myprofile')->name('school.profile');
        Route::post('/profile/{id}/update', 'SchoolController@updateProfile')->name('school.updateProfile');

        Route::get('/', 'SchoolController@index')->name('school.dashboard');
        Route::get('/dashboard', 'SchoolController@index')->name('school.dashboard');
        Route::get('/teacher', 'SchoolController@teachers')->name('school.dashboard');
        Route::get('/teacher/add', 'SchoolController@addteacher')->name('school.addteacher');
        Route::get('/teacher/teacherslist', 'SchoolController@teacherslist')->name('school.teacherslist');
        Route::post('/teacher/add', 'SchoolController@storeTeacher')->name('school.storeteacher');
        Route::get('/teacher/{id}/edit', 'SchoolController@editTeacher')->name('school.editTeacher');
        Route::post('/teacher/{id}/edit', 'SchoolController@updateTeacher')->name('school.updateTeacher');
        Route::get('/classes','SchoolController@classes')->name('school.classes');
        Route::get('/classes/create','SchoolController@createClass')->name('school.add-class');
        Route::post('/classes/create','SchoolController@storeClass')->name('school.add-class');
        Route::get('/classlist','SchoolController@classlist')->name('school.classlist');
        Route::get('/classes/{id}/edit','SchoolController@classEdit')->name('school.classEdit');
        Route::post('/classes/{id}/edit','SchoolController@classUpdate')->name('school.classUpdate');
        Route::get('/classes/{id}/delete', 'SchoolController@classDestroy');
        Route::get('/classes/{id}/restore', 'SchoolController@classRestore');

        Route::get('/students', 'SchoolController@students');
        Route::get('/studentlist', 'SchoolController@showStudents');
        Route::get('/students/add', 'SchoolController@createStudents');
        Route::post('/students/add','SchoolController@storeStudents');
        Route::get('/students/{id}/edit', 'SchoolController@editStudents');
        Route::post('/students/{id}/edit', 'SchoolController@updateStudents');

        Route::get('/users/{id}/destroy', 'SchoolController@destroy');
        Route::get('/users/{id}/restore', 'SchoolController@restore');

        Route::get('/materials', 'SchoolController@materials')->name('admin.contents');
        Route::get('/materialslist', 'SchoolController@getMaterialDataAjax')->name('admin.contentslist');
        Route::get('/materials/add/', 'SchoolController@createMaterial')->name('admin.contentsAdd');
        Route::post('/materials/add/', 'SchoolController@storeMaterial')->name('admin.contentsAdd');
        Route::get('/materials/{id}/edit', 'SchoolController@editMaterial')->name('admin.contentsEdit');
        Route::post('/materials/{id}/edit', 'SchoolController@updateMaterial')->name('admin.contentsUpdate');
        Route::get('/materials/{id}/delete', 'SchoolController@destroyMaterial')->name('admin.contentsDestroy');
        Route::get('/materials/{id}/restore', 'SchoolController@restoreMaterial')->name('admin.contentsRestore');
        Route::post('/materials/deleteselected', 'SchoolController@deleteSelectedMaterial')->name('admin.contentsDeleteSelected');

    });

    // For School District
    Route::prefix('schooldistrict')->group(function () {

        Route::get('/profile', 'SchoolDistrictController@myprofile')->name('school.profile');
        Route::post('/profile/{id}/update', 'SchoolDistrictController@updateProfile')->name('school.updateProfile');

        Route::get('/', 'SchoolDistrictController@dashboard')->name('schooldistrict.dashboard');
        Route::get('/dashboard', 'SchoolDistrictController@dashboard')->name('schooldistrict.dashboard');
        Route::get('/schools', 'SchoolDistrictController@schoolslistview')->name('schooldistrict.schoolslistview');
        Route::get('/schoolslist', 'SchoolDistrictController@schoolslist')->name('schooldistrict.schoolslist');

        Route::get('/teachers', 'SchoolDistrictController@teacherslistview')->name('schooldistrict.teacherslistview');
        Route::get('/teacherslist', 'SchoolDistrictController@teacherslist')->name('schooldistrict.teacherslist');
        Route::get('/students', 'SchoolDistrictController@studentslistview')->name('schooldistrict.studentslistview');
        Route::get('/studentslist', 'SchoolDistrictController@studentslist')->name('schooldistrict.studentslist');
        Route::get('/materilasreport','SchoolDistrictController@materilasreport')->name('schooldistrict.materilasreport');
        Route::get('/materilaslist','SchoolDistrictController@materilaslist')->name('schooldistrict.materilaslist');
    });

    Route::post('/changepassword','ChangePassword@changePassword');

    // For Portal Admin
    Route::prefix('portaladmin')->group(function(){

        Route::get('/profile', 'PortalAdminController@myprofile')->name('admin.profile');
        Route::post('/profile/{id}/update', 'PortalAdminController@updateProfile')->name('admin.updateProfile');

        Route::get('/', 'PortalAdminController@index')->name('admin.dashboard');
        Route::get('/dashboard', 'PortalAdminController@index')->name('admin.dashboard');
        Route::get('/users', 'PortalAdminController@users')->name('admin.users');
        Route::get('/userslist', 'PortalAdminController@userslist')->name('admin.users');
        Route::get('/users/add', 'PortalAdminController@usersAdd')->name('admin.usersAdd');
        Route::post('/users/add', 'PortalAdminController@storeUser')->name('admin.usersAddSubmit');
        Route::get('/users/{id}/edit', 'PortalAdminController@userEdit')->name('admin.userEdit');
        Route::post('/users/{id}/update', 'PortalAdminController@userUpdate')->name('admin.userUpdate');
        Route::get('/users/{id}/destroy', 'PortalAdminController@destroy')->name('admin.userDestroy');
        Route::get('/users/{id}/restore', 'PortalAdminController@restore')->name('admin.Restore');
        //
        Route::get('/schools', 'PortalAdminController@schools')->name('admin.schools');
        Route::get('/schoolslist', 'PortalAdminController@schoolslist')->name('admin.schoolslist');
        Route::get('/schools/add', 'PortalAdminController@schoolAdd')->name('admin.schoolsAdd');
        Route::post('/schools/add', 'PortalAdminController@storeSchool')->name('admin.schoolsAddSubmit');
        Route::get('/schools/{id}/edit', 'PortalAdminController@schoolEdit')->name('admin.schoolsEdit');
        Route::post('/schools/{id}/update', 'PortalAdminController@schoolUpdate')->name('admin.schoolsUpdate');
        Route::get('/schools/{id}/delete', 'PortalAdminController@schoolDestroy');
        Route::get('/schools/{id}/restore', 'PortalAdminController@schoolRestore');


        Route::get('/materials', 'PortalAdminController@materials')->name('admin.contents');
        Route::get('/materialslist', 'PortalAdminController@getMaterialDataAjax')->name('admin.contentslist');
        Route::get('/materials/add/', 'PortalAdminController@createMaterial')->name('admin.contentsAdd');
        Route::post('/materials/add/', 'PortalAdminController@storeMaterial')->name('admin.contentsAdd');
        Route::get('/materials/{id}/edit', 'PortalAdminController@editMaterial')->name('admin.contentsEdit');
        Route::post('/materials/{id}/edit', 'PortalAdminController@updateMaterial')->name('admin.contentsUpdate');
        Route::get('/materials/{id}/delete', 'PortalAdminController@destroyMaterial')->name('admin.contentsDestroy');
        Route::get('/materials/{id}/restore', 'PortalAdminController@restoreMaterial')->name('admin.contentsRestore');
        Route::post('/materials/deleteselected', 'PortalAdminController@deleteSelectedMaterial')->name('admin.contentsDeleteSelected');

        //Reports
        Route::get('/reports/teachers', 'PortalAdminController@getTeachers')->name('admin.teachers');
        Route::get('/teacherslist', 'PortalAdminController@getTeachersList')->name('admin.teacherslist');
        Route::get('/reports/students', 'PortalAdminController@getStudents')->name('admin.students');
        Route::get('/studentslist', 'PortalAdminController@getStudentsList')->name('admin.studentslist');
        Route::get('/reports/schooldistrcts', 'PortalAdminController@getSchoolDistricts')->name('admin.schooldistrcts');
        Route::get('/schooldistrctslist', 'PortalAdminController@getSchoolDistrictsList')->name('admin.schooldistrctslist');
        Route::get('/reports/schooladmins', 'PortalAdminController@getSchoolAdmins')->name('admin.schooladmins');
        Route::get('/schooladminslist', 'PortalAdminController@getSchoolAdminsList')->name('admin.schooladminslist');

    });

    Route::get('about', 'CmsPagesController@aboutPage');
    Route::get('contact', 'CmsPagesController@contactPage');
    Route::get('faq', 'CmsPagesController@faqPage');
});



