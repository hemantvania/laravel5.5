<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use Yajra\DataTables\DataTables;
use App\Http\Requests\ContentAddRequest;
use App\Http\Requests\UserAddAdmin;
use App\Http\Requests\UserUpdateAdmin;
use Hash;
use DB;
use Lang;
use Session;
use Redirect;
use App;
use Auth;
use App\User;
use App\Material;
use App\Teachers;
use App\Students;
use App\School;
use App\UsersSchools;
use App\UserMeta;
use App\UsersClasses;
use App\ClassMaterials;
use App\RolesCountry;
use ZipArchive;
use File;
use App\Events\StartClass;
use App\Thread;
use App\ThreadParticipant;
use App\Message;
use App\Events\NewMessage;
use App\Http\Custom\Helper;
use App\ManageEdesk;
use Carbon\Carbon;

class TeacherController extends Controller
{
    public $schoolid = '';

    /**
     * TeacherController constructor.
     */
    public function __construct()
    {
        $this->middleware('teacher');
        $this->middleware(function ($request, $next) {
            if (session('school_id')) {
                $this->schoolid = session('school_id');
            } else {
                $primarySchoolId = Auth::user()->userMeta->default_school;
                if (!empty($primarySchoolId)) {
                    $this->schoolid = $primarySchoolId;
                } else {
                    $teachers = new Teachers();
                    $schoolinfo = $teachers->getTeacherSchools(true);
                    if (!empty($schoolinfo)) {
                        $this->schoolid = $schoolinfo->school_id;
                    }
                }
            }
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $screenAuth = Auth::User()->UserMeta->enable_share_screen;
        $logourl = '';
        $objMaterial = new Material();
        $objTeachers = new Teachers();
        $objSchool = new School();
        $objRoleCountry = new RolesCountry();
        $objUserSchools = new UsersSchools();
        $objThreadP = new ThreadParticipant();
        $types = $objMaterial->getAllType();
        $owners = $objMaterial->getAllOwner();
        $schoolDetails = $objTeachers->getSchoolInfo($this->schoolid);
        if (!empty($schoolDetails->logo)) {
            $path = storage_path() . '/app/' . $schoolDetails->logo;
            if (File::exists($path)) {
                $logourl = generateLangugeUrl(App::getLocale(), url($schoolDetails->logo));
            }
        }
        $classes = $objTeachers->getTeacherAssignClasses($this->schoolid);
        $defaultAssignClass = $objTeachers->getTeacherDefaultClass($this->schoolid);
        if (!empty($defaultAssignClass)) {
            $students = $objTeachers->getAssignStudentsInClass($defaultAssignClass->class_id);
        } else {
            $students = array();
        }
        $userDetail = Auth::user();
        $schoolsList = $objSchool->getList();
        $rolesList = $objRoleCountry->getRoleByCountry(Auth::user()->userMeta->country);
        $user_schools = $objUserSchools->getUserSchools(Auth::user()->id);
        $my_schools = $objUserSchools->getUserSchools(Auth::user()->id, false);
        // Fetching existing thread ids
        $threads = $objThreadP->getAllThreadIdForUser(Auth()->id());
        return view('teacher.dashboard', compact('types', 'owners', 'classes', 'students', 'defaultAssignClass', 'logourl', 'userDetail', 'schoolsList', 'rolesList', 'user_schools', 'my_schools', 'threads', 'screenAuth'));
    }

    /**
     * Process datatables ajax request.
     * @return mixed
     */
    public function materiallist()
    {
        $objMaterial = new Material();
        $materials = $objMaterial->getMaterialList();
        return Datatables::of($materials)
            ->addColumn('action', function ($material) {
                return $this->generateAction($material);
            })
            ->addColumn('viewlink', function ($material) {
                return $this->generateMaterialLink($material);
            })
            ->addColumn('statusurl', function ($material) {
                return $this->fngenerateoptions($material);
            })
            ->addColumn('deloption',function($material){
                return $this->fngenerateTeacherDeleteOptions($material);
            })
            ->make(true);
    }

    /**
     * Generate the change status url of specific materials in gird list
     * @param $material
     * @return mixed|string
     */
    public function fngenerateoptions($material)
    {
        return $statusurl = generateLangugeUrl(App::getLocale(), url("/teacher/materials/changestatus"));
    }

    /**
     * Generate Specific Materials link
     * @param $material
     * @return string
     */
    public function generateMaterialLink($material)
    {
        $output = '';
        $output .= $material->link;
        return $output;
    }

    /**
     * Process data tables ajax request Generate Action Field.
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateAction($material)
    {

        $output = "";
        $output .= '<input type="checkbox" id="material_' . $material->id . '" name="materialsids[]" value="' . $material->id . '" /><label for="material_' . $material->id . '"></label>';
        return $output;
    }

    /**
     * Return delete option if materialas is uploded by logged in teacher
     * @param $material
     * @return bool
     */
    public function fngenerateTeacherDeleteOptions($material){
        if(Auth::user()->id == $material->uploadBy) {
            return 'true';
        } else {
            return 'false';
        }
    }

    /**
     * Show students
     * @return mixed
     */
    public function showStudents()
    {
        $objTeachers = new Teachers();
        $students = $objTeachers->getSchoolUserList($this->schoolid);
        return Datatables::of($students)
            ->addColumn('assign', function ($student) {
                return $this->generateCheckboxColumn($student);
            })
            //25-10-17    ->addColumn('action',function($student){ return $this->generateStudents($student);})
            ->make(true);
    }

    /**
     * Process data tables ajax request Generate Action Field.
     * @param $student
     * @return string
     */
    public function generateStudents($student)
    {

        $output = "";
        if ($student->deleted_at) {
            $restoreurl = generateLangugeUrl(App::getLocale(), url("/teacher/students/" . $student->id . "/restore"));
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $student->id . '" data-url="' . $restoreurl . '" data-toggle="tooltip" title="Restore" class="restore-adminusers btn btn-primary"><i class="fa fa-undo"></i></a>';
            $output .= '</div>';
        } else {
            $url = generateLangugeUrl(App::getLocale(), url("/teacher/students/" . $student->id . "/edit"));
            $delurl = generateLangugeUrl(App::getLocale(), url("/teacher/students/" . $student->id . "/destroy"));
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" class="btn edit_student btn-primary" data-url="' . $url . '" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i ></a>';
            $output .= '</div>';
            $output .= '&nbsp;';
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $student->id . '" data-url="' . $delurl . '" class="remove-adminusers btn btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o" ></i ></a>';
            $output .= '</div>';
        }
        return $output;
    }

    /**
     * Generate Checkbox Columns For Students Grid
     * @param $student
     * @return string
     */
    public function generateCheckboxColumn($student)
    {
        $outputstr = "";
        $outputstr .= $student->id;
        return $outputstr;
    }

    /**
     * Create Student From Teacher Dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createStudents()
    {
        $authUser = Auth::user();
        $objSchool = new School();
        $schoolsList = $objSchool->getList();
        $objTeachers = new Teachers();
        $schoolinfo = $objTeachers->getTeacherSchools();
        return view("teacher.add-student", compact('authUser', 'schoolsList', 'schoolinfo'));
    }

    /**
     * Store Student Information
     * @param UserAddAdmin $request
     * @return mixed
     */
    public function storeStudents(UserAddAdmin $request)
    {
        $objUser = new User();
        $data = $request->all();
        $request['password'] = Hash::make($request->get('password'));
        $create = $objUser->createUserAdmin($request);
        if ($create) {
            $message = array('sucess', 'message', __('adminuser.addsuccess'));
        } else {
            $message = array('error', 'message', __('adminuser.failure'));
        }
        return json_encode($message);
    }

    /**
     * Edit User Information
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editStudents($id)
    {
        $authUser = Auth::user();
        $user = new User();
        $school = new School();
        $userSchools = new UsersSchools();
        $teachers = new Teachers();
        $userDetail = $user->getUserById($id);
        $schoolsList = $school->getList();
        $user_schools = $userSchools->getUserSchools($id);
        $schoolinfo = $teachers->getTeacherSchools();
        return view("teacher.add-student", compact('authUser', 'schoolsList', 'userDetail', 'user_schools', 'schoolinfo'));
    }

    /**
     * Update User Information Based On Id
     * @param UserUpdateAdmin $request
     * @param $id
     * @return mixed
     */
    public function updateStudents(UserUpdateAdmin $request, $id)
    {
        $updateUser = new User();
        $updateUserMeta = new UserMeta();
        $userSchools = new UsersSchools();
        $updateUser = $updateUser->updateUser($request, $id);
        $updateMeta = $updateUserMeta->updateUserData($request, $id);
        $updateSchools = $userSchools->updateUserSchools($request, $id);
        if ($updateUser == true && $updateMeta == true && $updateSchools == true) {
            $message = array('sucess', 'message', __('adminuser.updatesuccess'));
            return json_encode($message);
        } else {
            $message = array('error', 'message', __('adminuser.failure'));
            return json_encode($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function studentDestroy($id)
    {
        $user = new User();
        $checkRecord = $user->checkUserExist($id);
        if ($checkRecord) {
            $userDelete = $user->deleteUser($id);
            if ($userDelete) {
                return response()->json([
                    'status' => true,
                    'message' => __('teacher.studentdeletesuccess')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('teacher.studentfailure')
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => __('teacher.studentnorecordsfound')
            ]);
        }
    }

    /**
     * Restore the specified resource in storage.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function studentRestore($id)
    {
        $user = new User();
        $restoreUser = $user->restoreRecord($id);
        if ($restoreUser) {
            return response()->json([
                'status' => true,
                'message' => __('teacher.studentrestoresuccess')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => __('teacher.studentfailure')
            ]);
        }
    }

    /**
     * Assign Student To Specific Class
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignStudents(Request $request)
    {
        $studentsids = $request->get('id');
        $classid = $request->get('classid');
        $added = false;
        foreach ($studentsids as $studentid) {
            $assignClass = new UsersClasses();
            $max = $assignClass->getClassLastSequence($classid);
            $sequence = 0;
            if (empty($max)) {
                $sequence = $sequence + 1;
            } else {
                $sequence = $max + 1;
            }
            $userClass = $assignClass->getAssignStudentCount($studentid);
            if ($userClass == '0') {
                $assignClass->assignStudent($studentid, $classid, $sequence);
                $added = true;
            }
        }
        if ($added == true) {
            return response()->json([
                'status' => true,
                'message' => __('teacher.assing_message')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => __('teacher.assing_failure_already')
            ]);
        }

    }

    /**
     * Assign Materials to specific classes
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignMaterials(Request $request)
    {
        $materilids = $request->get('materialsids');
        $classid = $request->get('classid');
        $added = false;
        foreach ($materilids as $materilid) {
            $assignMaterial = new ClassMaterials();
            $assignMaterial->deleteDuplicateAssignMaterialCount($classid, $materilid);
            $classMaterial = $assignMaterial->getAssignMaterialCount($classid, $materilid);
            if ($classMaterial == '0') {
                $assignMaterial->assignClassMaterials($classid, $materilid);
                $added = true;
            }
        }
        if ($added == true) {
            return response()->json([
                'status' => true,
                'message' => __('teacher.assing_material_message')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => __('teacher.assing_material_failure')
            ]);
        }
    }

    /**
     * List out users for specific classes
     * @param Request $request
     * @return mixed
     */
    public function showDeskuser(Request $request)
    {
        $classid = $request->get('showid');
        $teachers = new Teachers();
        $students = $teachers->getAssignStudentsInClass($classid);
        foreach ($students as $student) {
            $check = "vdeskusers:" . $student->id;
            $status = Redis::keys($check);
            if (!empty ($status)) {
                $student['is_active'] = '1';
            } else {
                $student['is_active'] = '0';
            }
        }
        return view("teacher.list-desk-student", compact('students', 'onlineusers'));
    }

    /**
     * Functions is create for download materials
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function downloadMaterials(Request $request)
    {
        $material = new Material();
        if (count($request->get('contents')) != 0) {
            $storage_path = storage_path('app');
            $contents = $request->get('contents');
            $filePaths = $material->downloadProcess($contents);
            if (!empty($filePaths)) {
                $zip = new ZipArchive;
                $fileName = 'material-' . date("Y-m-d-h-i-s") . '.zip';
                $archive_name = storage_path('app') . $fileName;
                $zip = new ZipArchive;
                if ($zip->open($archive_name, ZipArchive::CREATE) === TRUE) {
                    foreach ($filePaths as $file) {
                        $filePath = $storage_path . '/' . $file;
                        if (file_exists($filePath)) {
                            $zip->addFile($filePath, $file);
                        }
                    }
                    $zip->close();
                    $archive_file_name = basename($archive_name);
                    //unlink($archive_name);
                }
                return response()->json([
                    'status' => true,
                    'message' => __('teacher.download_material_message'),
                    'filename' => "/storage/" . $archive_file_name
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('teacher.download_material_failure')
                ]);
            }

        } else {
            return response()->json([
                'status' => false,
                'message' => __('teacher.download_material_notselect')
            ]);
        }
    }

    /**
     * Function is create for store material in DB
     * @param ContentAddRequest $request
     * @return mixed
     */
    public function storeMaterial(ContentAddRequest $request)
    {
        $create = Material::storeMaterial($request);
        if ($create) {
            return Redirect::to(App::getLocale() . '/teacher/dashboard')->with('message', __('adminmaterial.addsuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/teacher/dashboard')->with('message', __('adminmaterial.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * School Switch Selection for multi school
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function switchschool()
    {
        $teachers = new Teachers();
        $schools = $teachers->getTeacherSchools(false);
        $session_school = session('school_id');
        return view("teacher.schoolswitch", compact('schools', 'session_school'));
    }

    /**
     * For Multiple School Switch
     * @param Request $request
     */
    public function switchschoolupdate(Request $request)
    {

        $schoolid = $request->get('schooloptions');
        $request->session()->put('school_id', $schoolid);
        $value = session('school_id');
        return Redirect::to(App::getLocale() . '/teacher/dashboard');
    }

    /**
     * Function is create for change the material status online to downloadable and vise versa
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeMaterialStatus(Request $request)
    {
        $id = $request->get('materialid');
        $status = $request->get('status');
        $material = new Material();
        if (!empty($id)) {
            $checkMaterialExist = $material->geMaterialById($id);
            if (!empty($checkMaterialExist)) {
                $updateValue = $material->changeMaterialFormat($status, $id);
                if ($updateValue) {
                    return response()->json([
                        'status' => true,
                        'message' => __('teacher.updatestatus')
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => __('teacher.notupdatestatus')
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('teacher.notupdatestatus')
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => __('teacher.notupdatestatus')
            ]);
        }
    }

    /**
     * Update Profile data
     * @param UserUpdateAdmin $request
     * @param $id
     * @return mixed
     */
    public function updateProfile(UserUpdateAdmin $request, $id)
    {
        $user = new PortalAdminController();
        $update = $user->userUpdate($request, $id, true);
        $locale = isset($request->default_language) ? $request->default_language : App::getLocale() ;
        if ($update) {
            return Redirect::to($locale . '/teacher/dashboard')->with('message', __('adminuser.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to($locale . '/teacher/dashboard')->with('message', __('adminuser.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Get the request of start class if specifc class have some materials for today then it will allow start class
     * other wise it will return error
     * @param Request $request
     * @return mixed
     */
    public function startClass(Request $request)
    {
        $class_id = $request->get('classid');
        $dailyMaterials = new ClassMaterials();
        $total = $dailyMaterials->getTotalAssignMaterialsForToday($class_id);
        if ($total > 0) {
            if ($dailyMaterials->updateClassMaterials($class_id)) {
                \Event::fire(new App\Events\StartClass($class_id));
                $request->session()->put('class_id', $class_id);
                //Fetch The Online Students in the current selected Class
                $teachers = new Teachers();
                $students = $teachers->getAssignStudentsInClass($class_id);
                foreach ($students as $student) {
                    $check = "vdeskusers:" . $student->id;
                    $status = Redis::keys($check);
                    if (!empty ($status)) {
                        $student['is_active'] = '1';
                    } else {
                        $student['is_active'] = '0';
                    }
                }
                return response()->json([
                    'status' => true,
                    'onlinestudents' => $students,
                    'message' => __('teacher.classstarted')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('teacher.classfailed')
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => __('teacher.classhasnomaterials')
            ]);
        }
    }

    /**
     * Pause Class Events
     * @param Request $request
     */
    public function pauseClass(Request $request)
    {
        $class_id = $request->get('classid');
        \Event::fire(new App\Events\PauseClass($class_id));
    }

    /**
     * Stop Class Events
     * @param Request $request
     */
    public function stopClass(Request $request)
    {
        $class_id = $request->get('classid');
        \Event::fire(new App\Events\StopClass($class_id));
    }

    /**
     * Resume Class Events
     * @param Request $request
     */
    public function resumeClass(Request $request)
    {
        $class_id = $request->get('classid');
        \Event::fire(new App\Events\StartClass($class_id));
    }

    /**
     * Check Total Online Student in Specific Class
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkOnlineStudentsInClass(Request $request)
    {
        $classid = $request->get('classid');
        $teachers = new Teachers();
        $students = $teachers->getAssignStudentsInClass($classid);
        $totalStudent = 0;
        $onlineStudent = 0;
        foreach ($students as $student) {
            $check = "vdeskusers:" . $student->id;
            $status = Redis::keys($check);
            if (!empty ($status)) {
                $student['is_active'] = '1';
                $onlineStudent++;
            } else {
                $student['is_active'] = '0';
            }
            $totalStudent++;
        }
        $status = $onlineStudent . '/' . $totalStudent;
        return response()->json([
            'status' => true,
            'online' => $status
        ]);
    }

    /**
     * Notification Grid list ing data
     * @return mixed
     */
    public function getTeacherNotificationList()
    {
        $teachers = new Teachers();
        $notifications = $teachers->getTeachersStudentNotification($this->schoolid);
        return Datatables::of($notifications)->make(true);
    }

    /**
     * Checking if the students have some thread or not
     * if not then it will craete new thread and will assign selected students and teacher into that thread
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkThread(Request $request)
    {

        $threadid = $request->get('threadid');
        $original = $request->get('studentsids');
        $ids = $original . ',' . Auth()->id();
        $objThreadP = new ThreadParticipant();
        $objThread = new Thread();
        $authid = Auth::user()->id;
        $reverseIds = Auth()->id() . ',' . $original;
        if (empty($threadid)) {
            $haveit = $objThreadP->checkThreadParticipant($ids);
            if ($haveit == 0) {
                $haveit = $objThreadP->checkThreadParticipant($reverseIds);
                if ($haveit > 0) {
                    $ids = $reverseIds;
                }
            }
            if ($haveit > 0) {
                $threadidobj = $objThreadP->getThreadId($ids);
                $threadid = $threadidobj['thread_id'];
            } else {
                $threadid = $objThread->createThread($authid);
                //Insert Participant in this thread
                $objThreadP->assignParticipantInThread($ids, $threadid);
                $userids = explode(',', $ids);
                foreach ($userids as $userid) {
                    \Event::fire(new App\Events\Thread($threadid, $userid));
                }
            }
        }
        $objmessage = new Message();
        $message = $objmessage->getThreadMessages($threadid);
        $students = $objmessage->getChatUsers($ids);
        $ouput = view("teacher.chat-messages", compact('message', 'threadid', 'students', 'original'))->render();
        return response()->json([
            'threadid' => $threadid,
            'message' => $ouput
        ]);
    }

    /**
     * Sending Message to students
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendMessage(Request $request)
    {
        $message = $request->get('message');
        $thread_id = $request->get('threadid');
        $objmessage = new Message();
        $messageid = $objmessage->sendThreadMessage($thread_id, $message);
        $chattime = Carbon::now();
        $formattedtime = $chattime->format('d-m-Y h:i A');
        \Event::fire(new App\Events\NewMessage($thread_id, $message, Auth()->user()->name, Auth()->id(), Auth()->user()->userrole,$formattedtime));
        return view("teacher.chat-messages-teacher", compact('message', 'messageid'));
    }

    /**
     * ScreenShare Ajax Handler
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function shareScreen(Request $request)
    {
        $studentsids = $request->get('shareids');
        $isViwer = $request->get('viwer');
        $userRole = Auth::user()->userrole;

        if (!empty($studentsids)) {
            $helper = new Helper();
            $resdata = json_decode($helper->getJoinMeAccess());
            if(!empty($resdata->presenterLink) && !empty($resdata->viewerLink)) {
                if (!empty($resdata->status)) {
                    return response()->json([
                        'status' => false,
                        'message' => !empty($resdata->message)
                    ]);
                } else {
                    $userids = explode(',', $studentsids);
                    $viewRequestBy = ucwords(Auth::user()->name);
                    foreach ($userids as $userid) {
                        if ($isViwer == 'false') {
                            \Event::fire(new App\Events\StartScreenShare($userid, $resdata->presenterLink, $viewRequestBy, $isViwer,$userRole));
                        } else {
                            \Event::fire(new App\Events\StartScreenShare($userid, $resdata->viewerLink, $viewRequestBy, $isViwer,$userRole));
                        }
                    }
                    return response()->json([
                        'status' => true,
                        'presenterLink' => $resdata->presenterLink,
                        'viewerLink' => $resdata->viewerLink,
                        'requestedBy' => $viewRequestBy,
                        'isViwer' => $isViwer,
                        'userRole' => $userRole,
                    ]);
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

    /**
     * Touch On / Off Specific students
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function managetouch(Request $request)
    {

        $returnStatus = '';
        $studentid = $request->get('studentid');
        $classid = $request->get('studentclassid');
        $status = $request->get('status');
        $teacherid = Auth::user()->id;
        $ManageEdesk = new ManageEdesk();
        if ($status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        $deskstatus = $ManageEdesk->getManageEdeskByStudentClassID($studentid, $classid, $teacherid);
        if (!empty($deskstatus)) {
            $id = $deskstatus['id'];
            $status = $deskstatus['is_active'];
            if ($status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $ManageEdesk->updateManageEdeskById($id, $status);

        } else {
            $ManageEdesk->insertToManageEdesk($studentid, $classid, $teacherid, $status);
        }
        $returnStatus = $status;
        \Event::fire(new App\Events\StudentLock($studentid, $classid, $status));
        return response()->json([
            'status' => true,
            'active' => $returnStatus
        ]);
    }

    public function deleteMaterials(Request $request){
        $materialid  = $request->get('materialid');
        $objMaterial = new Material();
        $objMaterial->destroyMaterialById($materialid);
        return response()->json([
            'status' => true,
            'message' => __('teacher.deletesuccess')
        ]);
    }
}
