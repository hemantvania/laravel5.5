<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Students;
use Auth;
use App\User;
use Redirect;
use App\StudentActivity;
use App\StudentClassStatus;
use Illuminate\Support\Facades\Lang;
use App\Http\Requests\UserUpdateAdmin;
use App\Http\Controllers\PortalAdminController;
use App\UsersSchools;
use App\Events\StudentStatus;
use Illuminate\Support\Facades\Redis;
use App\Thread;
use App\ThreadParticipant;
use App\Message;
use App\UsersMaterialStatistics;
use App\Http\Custom\Helper;
use App\ManageEdesk;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('student');
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classStatus = array();
        $eDeskList = array();
        $userClass = Auth::user()->classes()->with('studentClass')->first();
        $objThreadP = new ThreadParticipant();
        $touchstatus = 0;
        $threads = $objThreadP->getAllThreadIdForUser(Auth()->id());
        if (!empty($userClass->class_id)) {
            $classStatus = StudentClassStatus::isCompletedClass($userClass->class_id, Auth::user()->id);
            if (!$classStatus) {
                $student = new Students();
                $eDeskList = $student->getStudentEdeskListByClass($userClass->class_id);
                $isCommStarted = 1; // Assigned as Communication tool is started by teacher, It's static and will be replaced with comm. tool start and stop
                if (count($eDeskList) > 0) {
                    foreach ($eDeskList as $desk) {
                        $check = "vdeskusers:" . $desk->user_id;
                        $status = Redis::keys($check);
                        if (!empty ($status)) {
                            $desk['is_active'] = '1';
                        } else {
                            $desk['is_active'] = '0';
                        }
                        $desk['is_commu_on'] = $isCommStarted;
                    }
                }
            }
            // For Lock Screen By Teacher for this class for logged in students
            $ManageEdesk = new ManageEdesk();
            $statusArr = $ManageEdesk->getManageEdeskByStudent(Auth::user()->id, $userClass->class_id);
            if (!empty($statusArr)) {
                $touchstatus = $statusArr['is_active'];
            } else {
                $touchstatus = 0;
            }
        }
        $matirialsList = Students::getMaterialList();
        $userDetail = Auth::user();
        $userSchools = new UsersSchools();
        $user_schools = $userSchools->getUserSchools($userDetail->id);
        return view('student.dashboard', compact('matirialsList', 'userClass', 'classStatus', 'userDetail', 'user_schools', 'eDeskList', 'threads', 'touchstatus'));
    }

    /**
     * Get Class Materials
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getClassMaterials(Request $request)
    {
        $classid = $request->get('classid');
        $classStatus = array();
        $userClass = Auth::user()->classes()->with('studentClass')->first();
        //  dd();
        if (!empty($userClass->class_id)) {
            $classStatus = StudentClassStatus::isCompletedClass($userClass->class_id, Auth::user()->id);
        }
        $userDetail = Auth::user();

        $userSchools = new UsersSchools();
        $user_schools = $userSchools->getUserSchools($userDetail->id);

        $matirialsList = Students::getMaterialList($classid);

        return view('student.materialstlist_tab', compact('matirialsList', 'userClass', 'classStatus', 'userDetail', 'user_schools'));
    }

    /**
     * Class Completed
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function classCompleted(Request $request)
    {
        $classid = $request->get('classid');
        if (StudentClassStatus::setClassCompleted($classid)) {
            $studentid = Auth::user()->id;
            $studentname = Auth::user()->name;
            \Event::fire(new App\Events\StudentStatus($studentid, $classid, $studentname));
            return response()->json([
                'status' => true,
                'message' => Lang::get('messages.your_data_saved_successfully') //__('messages.your_data_saved_successfully')
            ]);

        } else {
            return response()->json([
                'status' => false,
                'message' => Lang::get('adminclasses.failure') //__('adminclasses.failure')
            ]);
        }
    }

    /**
     * Profile update
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
            return Redirect::to($locale . '/home')->with('message', __('adminuser.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to($locale . '/users/add')->with('message', __('adminuser.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Send message by student to teacher or other students
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function sendMessage(Request $request)
    {
        if ($request->get('to_user_id')) {
            $toUserName = $request->get('to_user_name');
            $toUserId = $request->get('to_user_role');
            $threadid = $request->get('thread_id');
            $message = $request->get('message');
            $messages = array();
            if ($message) {
                $objmessage = new Message();
                $messageid = $objmessage->sendThreadMessage($threadid, $message);
                $chattime = Carbon::now();
                $formattedtime = $chattime->format('d-m-Y h:i A');
                \Event::fire(new App\Events\NewMessage($threadid, $message, Auth()->user()->name, Auth()->id(), Auth::user()->userrole,$formattedtime));
                $messages = $objmessage->getThreadMessages($threadid);
            }
            return view("student.messages", compact('messages', 'threadid', 'students', 'toUserId'));
        } else {
            return response()->json([
                'status' => false,
                'message' => Lang::get('messages.error_failure')
            ]);
        }
    }

    /**
     * It will check for theadid and message as per it
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkThread(Request $request)
    {
        $toUserId = $request->get('to_user_id');
        $toUserRole = $request->get('to_user_role');
        $toUserName = $request->get('to_user_name');
        $threadid = $request->get('thread_id');
        $authid = Auth::user()->id;
        if (empty($threadid)) {
            $ids = $toUserId . ',' . Auth()->id();
            $reverseIds = Auth()->id() . ',' . $toUserId;
            $objThreadP = new ThreadParticipant();
            $objThread = new Thread();

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
        $laleb = Lang::get('teacher.label_message_to_teacher');
        if ($toUserRole != 2) {
            $laleb = Lang::get('teacher.label_send_message') . " " . strtoupper($toUserName);
        }
        $objmessage = new Message();
        $messages = $objmessage->getThreadMessages($threadid);

        //  $students   = $objmessage->getChatUsers($ids);
        $ouput = view("student.messages", compact('messages', 'threadid', 'toUserId'))->render();
        return response()->json([
            'threadid' => $threadid,
            'message' => $ouput,
            'sendername' => Auth::user()->name,
            'label' => $laleb,
        ]);
    }

    /**
     * This will add viewed material to users_material_statistics
     * @param Request $request
     */
    function addToViewedMaterial(Request $request)
    {
        $classid = $request->get('class_id');
        $material_id = $request->get('material_id');
        $objMaterialStatistics = new UsersMaterialStatistics();
        $recordsCount = $objMaterialStatistics->GetTodayStatusOfMaterials($classid, Auth::user()->id, $material_id);
        if ($recordsCount == 0) {
            $objMaterialStatistics->InsertInToStatistics($classid, Auth::user()->id, $material_id, 1);
        }
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
}
