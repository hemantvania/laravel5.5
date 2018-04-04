           <form id="addedit_user" role="form" @if(isset($userDetail)) action="{{ generateLangugeUrl(App::getLocale(),url(generateUrlPrefix().'/profile/'.$userDetail->id.'/update')) }}" @else  action="{{ generateLangugeUrl(App::getLocale(),url(generateUrlPrefix().'/users/add')) }}" @endif method="post" enctype="multipart/form-data">
                {{ csrf_field() }}

                <input id="hid_user_id" name="user_id" type="hidden" value="@if(isset($userDetail)){{$userDetail->id}}@endif">
                <input id="hid_country" name="country" type="hidden"value="@if(!empty($userDetail->userMeta->country)){{$userDetail->userMeta->country}}@endif">
               @if(isset($userDetail->userrole) && ($userDetail->userrole == 3 || $userDetail->userrole == 5 || $userDetail->userrole == 6  ) )
                <input id="hid_user_role" name="userrole" type="hidden" value="@if(isset($userDetail)){{$userDetail->userrole}}@endif">
                <input id="hid_schoolId" name="schoolId[]" type="hidden" value="@if(!empty($user_schools[0]) ){{$user_schools[0]}}@endif">
                @endif
               @if($userDetail->userrole == 5)
                   <input id="default_school" name="default_school" type="hidden" value="1">
               @else
                   <input id="default_school" name="default_school" type="hidden" value="@if(!empty($userDetail->userMeta->default_school)){{ $userDetail->userMeta->default_school }}@elseif(!empty($user_schools[0])){{$user_schools[0]}}@endif">
               @endif
               @if($userDetail->userrole == 2)
                   <input id="enable_share_screen" name="enable_share_screen" type="hidden" value="@if(!empty($userDetail->userMeta->enable_share_screen)){{$userDetail->userMeta->enable_share_screen}}@endif">
               @endif

                <div class="col-lg-3 col-xs-12">
                    <h4 class="personal-info-header">@lang('adminuser.profileimage')</h4>
                    <div class="picture-upload-cust">
                        @if(!empty($userDetail->userMeta->profileimage))
                            <img src="{{ url($userDetail->userMeta->profileimage) }}">
                            <!--button type="button" class="btn picture-remove"><i class="material-icons">close</i></button-->
                            <label class="checkbox-inline"><input name="remove_logo" value="1" type="checkbox">@lang('general.remove_profile_pic')</label>
                        @else
                            <img src="{{ asset('img/user2-160x160.jpg') }}">
                        @endif
                            <input type="hidden" name="userimage" value="{{ $userDetail->userMeta->profileimage }}" />
                    </div>
                    @if(Auth::user()->userrole != 3)
                    <div class="browse-picture-cust">
                        <label class="btn btn-vdesk btn-file">
                            <span id="logoname">@lang('adminuser.uploadphoto')</span>

                            <input id="user_profile" type="file" name="profileimage" style="display:none;">

                        </label>
                    </div>
                    @endif
                </div>

                <div class="col-lg-9 col-xs-12">
                    <div class="row">
                        <div class="col-lg-4 col-xs-12">
                            <div class="row">
                                <h4 class="personal-info-header">@lang('general.label_rersonal_details')</h4>
                                <div class="form-group col-xs-12 {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label>@lang('adminuser.first_name')<em>*</em></label>
                                    <input type="text"   @if(Auth::user()->userrole == 3) readonly @endif class="form-control" name="name" value="@if(!empty($userDetail->first_name)){{$userDetail->first_name}}@else{{ old('name') }}@endif" placeholder="@lang('adminuser.first_name')">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                    @endif
                                </div>
                                <div class="form-group col-xs-12 {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label>@lang('adminuser.last_name')<em>*</em></label>
                                    <input type="text" @if(Auth::user()->userrole == 3) readonly @endif class="form-control" name="last_name" value="@if(!empty($userDetail->last_name)){{$userDetail->last_name}}@else{{ old('last_name') }}@endif" placeholder="@lang('adminuser.last_name')">
                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                                        <strong>{{ $errors->first('last_name') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-xs-12 {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label>@lang('adminuser.email')<em>*</em></label>
                                    <input type="email" @if(Auth::user()->userrole == 3) readonly @endif class="form-control" value="@if(!empty($userDetail->email)){{$userDetail->email}}@else{{ old('email') }}@endif" name="email" placeholder="@lang('adminuser.email')">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-xs-12 {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label>@lang('adminuser.password')<em>*</em></label>
                                    <input type="password" @if(Auth::user()->userrole == 3) readonly @endif class="form-control" value="" name="password" autocomplete="off" placeholder="@lang('adminuser.password')">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-xs-12 {{ $errors->has('ssn') ? ' has-error' : '' }}">
                                    <label>@lang('adminuser.ssn')</label>
                                    <input type="text" @if(Auth::user()->userrole == 3) readonly @endif class="form-control" value="@if(!empty($userDetail->userMeta->ssn)){{ $userDetail->userMeta->ssn }}@else{{ old('ssn') }}@endif" name="ssn" placeholder="@lang('adminuser.ssn')">
                                    @if ($errors->has('ssn'))
                                        <span class="help-block">
                                                        <strong>{{ $errors->first('ssn') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-xs-12 {{ $errors->has('gender') ? ' has-error' : '' }}">
                                    <label>@lang('adminuser.gender')</label>

                                    <select class="selectpicker" name="gender" id="gender" @if(Auth::user()->userrole == 3) disabled @endif>
                                        <option value="1" @if(empty($userDetail->userMeta->gender) || ( $userDetail->userMeta->gender == 1)) selected="selected" @endif >@lang('adminuser.male')</option>
                                        <option value="2" @if(!empty($userDetail->userMeta->gender) && ( $userDetail->userMeta->gender == 2)) selected="selected" @endif >@lang('adminuser.female')</option>
                                        <option value="3" @if(!empty($userDetail->userMeta->gender) && ( $userDetail->userMeta->gender == 3)) selected="selected" @endif>@lang('adminuser.other')</option>
                                    </select>
                                    @if ($errors->has('gender'))
                                        <span class="help-block">
                                                        <strong>{{ $errors->first('gender') }}</strong>
                                                    </span>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12">

                            <div class="row">
                                <h4 class="personal-info-header">@lang('general.label_address_details')</h4>

                                <div class="form-group col-xs-12 {{ $errors->has('addressline1') ? ' has-error' : '' }}">
                                    <label>@lang('adminuser.addressline1')<em>*</em></label>
                                    <input type="text" @if(Auth::user()->userrole == 3) readonly @endif class="form-control" value="@if(!empty($userDetail->userMeta->addressline1)){{ trim($userDetail->userMeta->addressline1)}}@else{{ old('addressline1') }}@endif"  name="addressline1" placeholder="@lang('adminuser.addressline1')">
                                    @if ($errors->has('addressline1'))
                                        <span class="help-block">
                                                        <strong>{{ $errors->first('addressline1') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-xs-12 {{ $errors->has('addressline2') ? ' has-error' : '' }}">
                                    <label>@lang('adminuser.addressline2')</label>
                                    <input type="text" @if(Auth::user()->userrole == 3) readonly @endif class="form-control" value="@if(!empty($userDetail->userMeta->addressline2)){{ $userDetail->userMeta->addressline2 }}@else{{ old('addressline2') }}@endif" name="addressline2" placeholder="@lang('adminuser.addressline2')">
                                </div>
                                <div class="form-group col-xs-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label>@lang('adminuser.phone')<em>*</em></label>
                                    <input type="text" @if(Auth::user()->userrole == 3) readonly @endif class="form-control" value="@if(!empty($userDetail->userMeta->phone)){{ $userDetail->userMeta->phone }}@else{{ old('phone') }}@endif" name="phone" placeholder="@lang('adminuser.phone')">
                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                                        <strong>{{ $errors->first('phone') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-xs-12 {{ $errors->has('city') ? ' has-error' : '' }}">
                                    <label>@lang('adminuser.city')<em>*</em></label>
                                    <input type="text" @if(Auth::user()->userrole == 3) readonly @endif class="form-control" value="@if(!empty($userDetail->userMeta->city)){{$userDetail->userMeta->city}}@else{{ old('city')}}@endif" name="city" placeholder="@lang('adminuser.city')">
                                    @if ($errors->has('city'))
                                        <span class="help-block">
                                                        <strong>{{ $errors->first('city') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-xs-12 {{ $errors->has('zip') ? ' has-error' : '' }}">
                                    <label>@lang('general.postal_code')<em>*</em></label>
                                    <input id="postal_code" @if(Auth::user()->userrole == 3) readonly @endif type="text" class="form-control" value="@if(!empty($userDetail->userMeta->zip)){{$userDetail->userMeta->zip}}@else{{ old('zip')}}@endif" name="zip" placeholder="@lang('general.postal_code')">
                                    @if ($errors->has('zip'))
                                        <span class="help-block">
                                                        <strong>{{ $errors->first('zip') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            @if(isset($userDetail) && ( $userDetail->userrole == 2 || $userDetail->userrole == 4 || $userDetail->userrole == 6 || $userDetail->userrole == 5) )
                                <div class="row">
                                    <h4 class="personal-info-header">@lang('general.label_other_details')</h4>
                                    @if($userDetail->userrole != 5)

                                    <div class="form-group col-xs-12">
                                        <label>@lang('general.label_myschool')</label>
                                        <ul class="list-group">

                                        @if(!empty($my_schools) && count($my_schools) > 0 )
                                            @foreach($my_schools as $school)
                                                @if(isset($school->school->schoolName) )
                                                    <li class="list-group-item">{{$school->school->schoolName}}  @if(session('school_id') && session('school_id') == $school->school->id)<span class="glyphicon glyphicon-ok pull-right"></span>@endif @if($userDetail->userMeta->default_school == $school->school->id && $userDetail->userrole == 2 ) <span class="pull-right">(P)</span>@endif </li>
                                                @endif
                                            @endforeach
                                        @else
                                            <li class="list-group-item">@lang('general.norecords')</li>
                                        @endif

                                        </ul>
                                    </div>
                                    @endif
                                    <div class="form-group col-xs-12 {{ $errors->has('userrole') ? ' has-error' : '' }}"  style="display: none;">
                                        <label>@lang('adminuser.userrole')<em>*</em></label>
                                        <select class="selectpicker" name="userrole" id="userrole">
                                            <option value="" disabled="disabled">@lang('adminuser.userrole')</option>
                                            @if(isset($rolesList) && !empty($rolesList))
                                                @foreach($rolesList as $role)
                                                    @if($role->rolename && $role->id != 1)
                                                    @if($role->id == $userDetail->userrole)
                                                            <option value="{{ $role->id }}" @if(!empty($userDetail->userrole)) @if($role->id == $userDetail->userrole) selected="selected" @endif @else
                                                            @if(!empty(old('userrole')))
                                                            @if($role->id == old('userrole'))
                                                            selected="selected"
                                                                    @endif
                                                                    @endif
                                                                    @endif
                                                            >{{ $role->rolename }}</option>
                                                        @endif
                                                   @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('userrole'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('userrole') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-xs-12 {{ $errors->has('schoolId') ? ' has-error' : '' }}"  style="display: none;">
                                        <label>@lang('adminuser.selectschool')<em>*</em></label>
                                        <select id="schoollist" class="selectpicker" name="schoolId[]" @if(!empty($userDetail) && ( $userDetail->userrole==2 || $userDetail->userrole==4 ) ) multiple="multiple" @endif />
                                        <option disabled="disabled" value="" @if(empty($userDetail)) selected="selected" @endif >@lang('adminuser.selectschool')</option>
                                        @if(!empty($schoolsList))
                                            @foreach($schoolsList as $school)
                                                @if($school->schoolName)
                                                    <option value="{{ $school->id }}" @if(!empty($user_schools)) @if(in_array($school->id, $user_schools )) selected="selected" @endif @else @if(!empty(old('schoolId'))) @if($school->id == old('schoolId')) selected="selected" @endif @endif @endif >{{ $school->schoolName }}</option>
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                    </select>
                                                    @if ($errors->has('schoolId'))
                                                        <span class="help-block">
                                                        <strong>{{ $errors->first('schoolId') }}</strong>
                                                    </span>
                                                    @endif
                                    </div>

                                    @if(isset($userDetail) && ( $userDetail->userrole == 2 || $userDetail->userrole == 4 || $userDetail->userrole == 6 || $userDetail->userrole == 5) )
                                    <div class="form-group col-xs-12 {{ $errors->has('default_language') ? ' has-error' : '' }}">
                                        <label>@lang('general.select_language')<em>*</em></label>
                                        <select id="default_language" class="selectpicker" name="default_language">
                                            <option value="">@lang('general.select_language')</option>
                                            @if(config('language.option'))
                                                @foreach(config('language.option') as $key=>$value)
                                                    <option value="{{$key}}" @if(old('default_language') == $key) selected @endif @if(!empty($userDetail->userMeta->language) && $userDetail->userMeta->language == $key) selected  @endif>{{$value}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('default_language'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('default_language') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            @endif

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <div class="form-group pull-right">
                                @if(Auth::user()->userrole != 3)
                                <button type="submit" name="submit" class="btn btn-vdesk">@if(isset($userDetail)) @lang('general.profile_update') @else @lang('adminuser.add') @endif</button>
                                @endif
                                <a class="btn btn-default btn-vdesk-light" href="{{ url(App::getLocale().'/'.generateUrlPrefix() ) }}">@lang('general.profile_cancel')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
