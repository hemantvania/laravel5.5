<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddAdmin;
use App\Http\Requests\UserUpdateAdmin;
use App\Http\Requests\SchoolAdmin;
use App\Http\Requests\SchoolAdminUpdate;
use App\Http\Requests\ContentAddRequest;
use App\Http\Requests\ContentUpdateRequest;
use App\Http\Requests\PortalAdminUpdateRequest;
use App\Http\Requests\ContentDeleteRequest;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App;
use App\User;
use App\UserMeta;
use App\School;
use App\RolesCountry;
use App\Countries;
use App\UsersSchools;
use App\Classes;
use App\Material;
use App\MaterialCategory;
use App\UsersAtivityTracker;
use Yajra\DataTables\DataTables;

class PortalAdminController extends Controller
{
    /**
     * PortalAdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('portaladmin');
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = new User();
        $totalCount = $user->getUsersCounts();
        $material = new Material();
        $totalView = $material->viewMaterialStatistic();
        $totalShare = $material->shareMaterialStatistic();
        $userActivity = new UsersAtivityTracker();
        $avgTotal = $userActivity->getUserActivityAvg();
        $totalSchools = School::count();
        return view('portaladmin.dashboard', compact('totalCount', 'totalView', 'totalShare', 'avgTotal', 'totalSchools'));
    }

    /**
     * Get users listing
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function users()
    {
        return view('portaladmin.users');
    }

    /**
     * Get users listing
     * @return mixed
     */
    public function userslist()
    {
        $users = User::getUserList();
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return $this->generateUsers($user);
            })
            ->make(true);
    }

    /**
     * Process data tables ajax request Generate Action Field.
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateUsers($user)
    {

        $output = "";
        if ($user->deleted_at) {
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $user->id . '" data-toggle="tooltip" title="Restore" class="restore-adminusers btn btn-primary"><i class="fa fa-undo"></i></a>';
            $output .= '</div>';
        } else {
            $url = url(App::getLocale() . '/' . generateUrlPrefix() . "/users/" . $user->id . "/edit");
            $output .= '<div class="btn-group">';
            $output .= '<a href="' . $url . '" class="btn btn-primary marbot" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i ></a>';
            $output .= '</div>';
            $output .= '&nbsp;';
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $user->id . '" class="remove-adminusers btn btn-danger marbot" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o" ></i ></a>';
            $output .= '</div>';
        }
        return $output;
    }

    /**
     * Show form to add new user with drop down data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function usersAdd()
    {
        $school = new School();
        $schoolsList = $school->getList();
        $roleCountry = new RolesCountry();
        $rolesList = $roleCountry->getRoleByCountry(Auth::user()->userMeta->country);
        $classes = new Classes();
        $classList = $classes->getClassList();
        $countries = new Countries();
        $countrieList = $countries->getCountryList();
        $authUser = Auth::user();
        return view("portaladmin.add-user", compact('schoolsList', 'rolesList', 'classList', 'countrieList', 'authUser'));
    }

    /**
     * Store a newly created resource in storage.
     * @param UserAddAdmin $request
     * @return mixed
     */
    public function storeUser(UserAddAdmin $request)
    {
        $create   = false;
        $user     = new User();
        $userData = array(
            'name'              => $request->get('name'),
            'last_name'         => $request->get('last_name'),
            'email'             => $request->get('email'),
            'password'          => $request->get('password'),
            'userrole'          => $request->get('userrole'),
            'country'           => $request->get('country'),
            'ssn'               => $request->get('ssn'),
            'gender'            => $request->get('gender'),
            'addressline1'      => $request->get('addressline1'),
            'addressline2'      => $request->get('addressline2'),
            'phone'             => $request->get('phone'),
            'city'              => $request->get('city'),
            'zip'               => $request->get('zip'),
            'schoolId'          => $request->get('schoolId'),
            'default_school'    => $request->get('default_school'),
            'default_language'  => $request->get('default_language')
        );

        if ($request->hasFile('profileimage')) {
            $userData['profileimage'] = $request->file('profileimage')->store("userprofile");
        } else {
            $userData['profileimage'] = '';
        }

        if(!empty($request->get('state'))){
            $userData['state'] = $request->get('state');
        } else {
            $userData['state'] = '';
        }
        if (!empty($request->get('enable_share_screen'))) {
            $userData['enable_share_screen'] = $request->get('enable_share_screen');
        } else {
            $userData['enable_share_screen'] = 0;
        }
        $userid =  $user->createUser($userData);
        if(!empty($userid)){
            $create = true;
            //Creating User Meta
            $userData['userid'] = $userid;
            $objUserMeta = new UserMeta();
            $metaid =  $objUserMeta->createUserMeta($userData);
            // Assign User to Schools
            $objUserSchools = new UsersSchools();
            if(!empty( $userData['schoolId'])){
                foreach ($userData['schoolId'] as $schoolids){
                    $objUserSchools->storeUsersSchool($userid,$schoolids);
                }
            }
        }
        //$create = $user->createUserAdmin($userData);
        if ($create) {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/users/')->with('message', __('adminuser.addsuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/users/add')->with('message', __('adminuser.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Edit form to update user's data
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userEdit($id)
    {
        $user = new User();
        $userDetail = $user->getUserById($id);
        $school = new School();
        $schoolsList = $school->getList();
        $roleCountry = new RolesCountry();
        $country = !empty($userDetail->userMeta->country) ? $userDetail->userMeta->country : 1; // 1 = Finland
        $rolesList = $roleCountry->getRoleByCountry($country);
        $countries = new Countries();
        $countrieList = $countries->getCountryList();
        $userSchools = new UsersSchools();
        $user_schools = $userSchools->getUserSchools($id);
        $mySchools = $userSchools->getUserSchools($id, false);
        $classes = new Classes();
        $classList = $classes->getClassList();
        $authUser = Auth::user();
        return view("portaladmin.add-user", compact('userDetail', 'schoolsList', 'rolesList', 'classList', 'countrieList', 'user_schools', 'authUser', 'mySchools'));
    }

    /**
     * Update user's details
     * @param UserUpdateAdmin $request
     * @param $id
     * @param bool $noRedirect
     * @return bool
     */
    public function userUpdate(UserUpdateAdmin $request, $id, $noRedirect = false)
    {
        $userData = array(
            'name'      => $request->get('name'),
            'last_name' => $request->get('last_name'),
            'email'     => $request->get('email'),
            'password'  => $request->get('password'),
            'userrole'  => $request->get('userrole'),
        );
        $updateUser = new User();
        $updateUser = $updateUser->updateUser($userData, $id);

        if ($request->get('userrole') == 4) {
            $share = 0;
        } else {
            $share = $request->get('enable_share_screen');
        }

        $userMeta = array(
            'country'               => $request->get('country'),
            'ssn'                   => $request->get('ssn'),
            'gender'                => $request->get('gender'),
            'addressline1'          => $request->get('addressline1'),
            'addressline2'          => $request->get('addressline2'),
            'phone'                 => $request->get('phone'),
            'city'                  => $request->get('city'),
            'zip'                   => $request->get('zip'),
            'default_school'        => $request->get('default_school'),
            'enable_share_screen'   => $share,
            'default_language'      => $request->get('default_language'),
        );

        if (!empty($request->hasFile('profileimage'))) {
            $userMeta['profileimage'] = $request->file('profileimage')->store("userprofile");
        } else {
            $userMeta['profileimage'] = $request->get('userimage');
        }

        if ($request->has('remove_logo')) {
            \File::delete(storage_path('app/' . $request->get('userimage')));
            $userMeta['profileimage'] = '';
        }

        if(!empty($request->get('state'))){
            $userMeta['state'] = $request->get('state');
        } else {
            $userMeta['state'] = '';
        }
        if (!empty($request->get('enable_share_screen'))) {
            $userMeta['enable_share_screen'] = $request->get('enable_share_screen');
        } else {
            $userMeta['enable_share_screen'] = 0;
        }

        $updateUserMeta = new UserMeta();
        $updateMeta     = $updateUserMeta->UpdateUserMeta($userMeta, $id);
        $schoolDeta     = $request->get('schoolId')[0];
        $updateSchools  = true;
        if (null !== $schoolDeta) {
            $schoolIds = $request->get('schoolId');
            $objUserSchools = new UsersSchools();
            $objUserSchools->deleteUsersSchool($id);
            foreach ($schoolIds as $schooid){
              $objUserSchools->storeUsersSchool($id,$schooid);
            }
           // $updateSchools = $userSchools->updateUserSchools($schoolIds, $id);
        }
        if ($noRedirect) {
            if ($updateUser == true && $updateMeta == true && $updateSchools == true) {
                return true;
            } else {
                return false;
            }
        }
        if ($updateUser == true && $updateMeta == true && $updateSchools == true) {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/users/')->with('message', __('adminuser.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/users/' . $id . '/edit')->with('message', __('adminuser.failure'))->with('class', 'alert-danger');
        }
    }


    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = new User();
        $checkRecord = $user->checkUserExist($id);
        if ($checkRecord) {
            $userDelete = $user->deleteUser($id);
            if ($userDelete) {
                return response()->json([
                    'status' => true,
                    'message' => __('adminuser.deletesuccess')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('adminuser.failure')
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminuser.norecordsfound')
            ]);
        }
    }

    /**
     * Restore the specified resource in storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $user = new User();
        $restoreUser = $user->restoreRecord($id);
        if ($restoreUser) {
            return response()->json([
                'status' => true,
                'message' => __('adminuser.restoresuccess')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminuser.failure')
            ]);
        }
    }

    /**
     * Show schools listing
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function schools()
    {
        return view('portaladmin.schools');
    }

    /**
     * Collect school listing to show on school listing page
     * @return mixed
     */
    public function schoolslist()
    {
        $school = new School();
        $list = $school->getList();
        return Datatables::of($list)
            ->addColumn('action', function ($list) {
                return $this->generateSchoolAction($list);
            })
            ->make(true);
    }

    /**
     * Process data tables ajax request Generate Action Field.
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateSchoolAction($school)
    {

        $output = "";
        if ($school->deleted_at) {
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $school->id . '" data-toggle="tooltip" title="Restore" class="restore-school btn btn-primary"><i class="fa fa-undo"></i></a>';
            $output .= '</div>';
        } else {
            $url = url(App::getLocale() . '/' . generateUrlPrefix() . "/schools/" . $school->id . "/edit");
            $output .= '<div class="btn-group">';
            $output .= '<a href="' . $url . '" class="btn btn-primary marbot" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i ></a>';
            $output .= '</div>';
            $output .= '&nbsp;';
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $school->id . '" class="remove-school btn btn-danger marbot" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o" ></i ></a>';
            $output .= '</div>';
        }
        return $output;
    }

    /**
     * Add School
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function schoolAdd()
    {

        $user = new User();
        $schoolDisctirictList = $user->getSchoolDistrict();
        $countries = new Countries();
        $countrieList = $countries->getCountryList();

        return view("portaladmin.add-school", compact('schoolDisctirictList', 'countrieList'));

    }

    /**
     * Store a newly created resource in storage.
     * @param SchoolAdmin $request
     * @return mixed
     */
    public function storeSchool(SchoolAdmin $request)
    {
        $schoolData = array(
            'schoolName' => $request->get('schoolName'),
            'email' => $request->get('email'),
            'registrationNo' => $request->get('registrationNo'),
            'WebUrl' => $request->get('WebUrl'),
            'address1' => $request->get('address1'),
            'address2' => $request->get('address2'),
            'city' => $request->get('city'),
            'state' => $request->get('state'),
            'zip' => $request->get('zip'),
            'country' => $request->get('country'),
            'facebook_url' => $request->get('facebook_url'),
            'twitter_url' => $request->get('twitter_url'),
            'instagram_url' => $request->get('instagram_url'),
            'logo' => $request->file('logo'),
            'school_district' => $request->get('school_district'),
            'language'=>$request->get('default_language')
        );
        $school = new School();
        $storeSchool = $school->storeSchool($schoolData);
        if ($storeSchool) {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/schools/')->with('message', __('adminschool.addsuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/schools/add')->with('message', __('adminschool.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function schoolEdit($id)
    {
        $school = new School();
        $schoolDetail = $school->getSchoolById($id);
        $discrictUser = $school->getSchoolDistrictByShoolId($id);
        $user = new User();
        $schoolDisctirictList = $user->getSchoolDistrict();
        $countries = new Countries();
        $countrieList = $countries->getCountryList();
        return view("portaladmin.add-school", compact('schoolDetail', 'schoolDisctirictList', 'countrieList', 'discrictUser'));
    }

    /**
     * Update the specified resource in storage.
     * @param SchoolAdminUpdate $request
     * @param $id
     * @return mixed
     */
    public function schoolUpdate(SchoolAdminUpdate $request, $id)
    {
        $schoolData = array(
            'schoolName' => $request->get('schoolName'),
            'email' => $request->get('email'),
            'registrationNo' => $request->get('registrationNo'),
            'WebUrl' => $request->get('WebUrl'),
            'address1' => $request->get('address1'),
            'address2' => $request->get('address2'),
            'city' => $request->get('city'),
            'state' => $request->get('state'),
            'zip' => $request->get('zip'),
            'country' => $request->get('country'),
            'facebook_url' => $request->get('facebook_url'),
            'twitter_url' => $request->get('twitter_url'),
            'instagram_url' => $request->get('instagram_url'),
            'remove_logo' => $request->get('remove_logo'),
            'logo' => $request->file('logo'),
            'school_district' => $request->get('school_district'),
            'language'=>$request->get('default_language')
        );
        $school = new School();
        $updateSchool = $school->schoolUpdate($schoolData, $id);
        if ($updateSchool) {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/schools/')->with('message', __('adminschool.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/schools/' . $id . '/edit')->with('message', __('adminschool.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function schoolDestroy($id)
    {
        $school = new School();
        $checkRecord = $school->checkRecordExist($id);
        if ($checkRecord) {
            $schoolDelete = $school->schoolDelete($id);
            if ($schoolDelete) {
                return response()->json([
                    'status' => true,
                    'message' => __('adminschool.deletesuccess')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('adminschool.failure')
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminschool.norecordsfound')
            ]);
        }
    }


    /**
     * Restore the specified resource in storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function schoolRestore($id)
    {
        $school = new School();
        $school = $school->restoreRecord($id);
        if ($school) {
            return response()->json([
                'status' => true,
                'message' => __('adminuserrole.restoresuccess')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminuserrole.failure')
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function materials()
    {
        return view("portaladmin.materials");
    }

    /**
     * Function is use for retrun material list on index
     * @return mixed
     */
    public function getMaterialDataAjax()
    {
        $materials = Material::getAllMaterialList();
        return Datatables::of($materials)
            ->addColumn('delaction',function($material){
                return $this->generateDelAction($material);
            })
            ->addColumn('action', function ($material) {
                return $this->generateMaterialAction($material);
            })
            ->make(true);
    }

    /**
     * Delete Multiple
     * @param $material
     * @return string
     */
    public function generateDelAction($material){
        $output = "";
        $output .= '<input type="checkbox" id="material_' . $material->id . '" name="materialsids[]" value="' . $material->id . '" /><label for="material_' . $material->id . '"></label>';
        return $output;
    }
    /**
     * Process data tables ajax request Generate Action Field.
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateMaterialAction($material)
    {

        $output = "";
        if ($material->deleted_at) {
            $output .= '<div class="btn-group">';
            $output .= '<a href="javascript:void(0);" data-index="' . $material->id . '" data-toggle="tooltip" title="Restore" class="restore-contents btn btn-primary"><i class="fa fa-undo"></i></a>';
            $output .= '</div>';
        } else {
            $editUrl = url(App::getLocale() . '/' . generateUrlPrefix() . "/materials/" . $material->id . "/edit");
            $output .= '<div class="btn-group">';
            $output .= '<a href="' . $editUrl . '" data-toggle="tooltip" title="Edit" class="btn btn-primary marbot"><i class="fa fa-edit"></i></a>';
            $output .= '</div>';
            $output .= '&nbsp;';
            $output .= '<div class="btn-group">';
            $output .= ' <a href="javascript:void(0);" data-index="' . $material->id . '" data-toggle="tooltip" title="Delete" class="remove-contents btn btn-danger marbot"><i class="fa fa-trash-o" ></i ></a>';
            $output .= '</div>';
        }
        return $output;
    }

    /**
     * Function create for render view files for add new content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createMaterial()
    {
        $materialCategory = new MaterialCategory();
        $materialCategories = $materialCategory->getCategories();
        $types = getUploadContentTypes();
        return view("portaladmin.add-materials", compact('materialCategories', 'types'));
    }

    /**
     * Function is create for store material in DB
     * @param ContentAddRequest $request
     * @return mixed
     */
    public function storeMaterial(ContentAddRequest $request)
    {
        $materialData = array(
            'materialType' => $request->get('materialType'),
            'materialName' => $request->get('materialName'),
            'description' => $request->get('description'),
            'categoryId' => $request->get('categoryId'),
            'link' => $request->get('link'),
            'uploadcontent' => $request->file('uploadcontent'),
            'materialIcon' => $request->file('materialIcon'),
            'language'=>$request->get('default_language')
        );
        $create = Material::storeMaterial($materialData);
        if ($create) {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/materials/')->with('message', __('adminmaterial.addsuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/materials/add')->with('message', __('adminmaterial.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Function is create for render Form for Edit material
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editMaterial($id)
    {
        $getMaterial = Material::geMaterialById($id);
        $materialCategory = new MaterialCategory();
        $materialCategories = $materialCategory->getCategories();
        $types = getUploadContentTypes();
        return view('portaladmin.add-materials', compact('getMaterial', 'materialCategories', 'types'));
    }

    /**
     * Function is create for update content detail
     * @param ContentUpdateRequest $request
     * @param $id
     * @return mixed
     */
    public function updateMaterial(ContentUpdateRequest $request, $id)
    {
        $material = array(
            'materialType' => $request->get('materialType'),
            'materialName' => $request->get('materialName'),
            'description' => $request->get('description'),
            'categoryId' => $request->get('categoryId'),
            'link' => $request->get('link'),
            'uploadcontent' => $request->file('uploadcontent'),
            'materialIcon' => $request->file('materialIcon'),
            'remove_materialIcon' => $request->get('remove_materialIcon'),
            'language'=>$request->get('default_language')
        );
        $update = Material::updateMaterialDetail($material, $id);
        if ($update) {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/materials/')->with('message', __('adminmaterial.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to(App::getLocale() . '/' . generateUrlPrefix() . '/materials/' . $id . '/edit')->with('message', __('adminmaterial.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Function is create for destroy/delete material record
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyMaterial($id)
    {
        $checkRecord = Material::geMaterialById($id);
        if (!empty($checkRecord)) {
            $destroy = Material::destroyMaterialById($id);
            if ($destroy) {
                return response()->json([
                    'status' => true,
                    'message' => __('adminmaterial.deletesuccess')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('adminmaterial.failure')
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminmaterial.norecordsfound')
            ]);
        }
    }

    /**
     * Delete Selected Materials
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSelectedMaterial(ContentDeleteRequest $request){
        $materialsids = $request->get('materialsids');
        $del = false;
        foreach ($materialsids as $mid) {
            $checkRecord = Material::geMaterialById($mid);
            if (!empty($checkRecord)) {
                $destroy = Material::destroyMaterialById($mid);
                if ($destroy) {
                    $del = true;
                }
            }
        }
        if ($del == true) {
            return response()->json([
                'status' => true,
                'message' => __('adminmaterial.deletesuccess')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminmaterial.failure')
            ]);
        }

    }

    /**
     * Restore the specified resource in storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restoreMaterial($id)
    {
        $restoreUser = Material::restoreRecord($id);
        if ($restoreUser) {
            return response()->json([
                'status' => true,
                'message' => __('adminmaterial.restoresuccess')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => __('adminmaterial.failure')
            ]);
        }
    }

    /**
     * Will show auth users details to update
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myprofile()
    {
        $userDetail = Auth::user();
        $school = new School();
        $schoolsList = $school->getList();
        $roleCountry = new RolesCountry();
        $rolesList = $roleCountry->getRoleByCountry(Auth::user()->userMeta->country);

        $userSchools = new UsersSchools();
        $user_schools = $userSchools->getUserSchools(Auth::user()->id);

        return view(generateUrlPrefix() . ".profile", compact('userDetail', 'schoolsList', 'user_schools', 'rolesList'));
    }

    /**
     * @param UserUpdateAdmin $request
     * @param $id
     * @return mixed
     */
    public function updateProfile(UserUpdateAdmin $request, $id)
    {
        $update = self::userUpdate($request, $id, true);
        $locale = isset($request->default_language) ? $request->default_language : App::getLocale() ;
        if ($update) {
            return Redirect::to($locale . '/' . generateUrlPrefix() . '/profile')->with('message', __('adminuser.updatesuccess'))->with('class', 'alert-success');
        } else {
            return Redirect::to($locale . '/' . generateUrlPrefix() . '/profile')->with('message', __('adminuser.failure'))->with('class', 'alert-danger');
        }
    }

    /**
     * Display teachers list report
     * @return $this
     */
    public function getTeachers()
    {
        return view('portaladmin.reports')->with('userrole', 'teachers');
    }

    /**
     * This function will return all teachers list
     * @return mixed
     */
    public function getTeachersList()
    {
        $userObj = new User();
        $teachers = $userObj->getUsersByRole('2');
        return Datatables::of($teachers)->make(true);
    }

    /**
     * Display Students list report
     * @return $this
     */
    public function getStudents()
    {
        return view('portaladmin.reports')->with('userrole', 'students');
    }

    /**
     * This function will return students list
     * @return mixed
     */
    public function getStudentsList()
    {
        $userObj = new User();
        $teachers = $userObj->getUsersByRole('3');
        return Datatables::of($teachers)->make(true);
    }

    /**
     * Display School Districts list report
     * @return $this
     */
    public function getSchoolDistricts()
    {
        return view('portaladmin.reports')->with('userrole', 'schooldistrcts');
    }

    /**
     * This function will return list of School Discrticts
     * @return mixed
     */
    public function getSchoolDistrictsList()
    {
        $userObj = new User();
        $teachers = $userObj->getUsersByRole('4');
        return Datatables::of($teachers)->make(true);
    }

    /**
     * Display School Admins list report
     * @return $this
     */
    public function getSchoolAdmins()
    {
        return view('portaladmin.reports')->with('userrole', 'schooladmins');
    }

    /**
     * This function will return list of school admins
     * @return mixed
     */
    public function getSchoolAdminsList()
    {
        $userObj = new User();
        $teachers = $userObj->getUsersByRole('6');
        return Datatables::of($teachers)->make(true);
    }

}
