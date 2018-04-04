   <div class="row">
       {{ csrf_field() }}
       <input id="hid_userrole" name="user_id" type="hidden"
              value="@if(isset($userDetail)){{$userDetail->userrole}}@endif">
       <input id="hid_country" name="country" type="hidden"
              value="@if(!empty($authUser->userMeta->country)){{$authUser->userMeta->country}}@endif">
       <input id="hid_role" name="userrole" type="hidden" value="3">
       <!--input id="schoolId" name="schoolId[]" type="hidden" value="{{$schoolinfo->school_id}}" -->
       <input id="schoolId" name="schoolId[]" type="hidden" value="@if(session('school_id')){{ session('school_id')  }}@elseif($authUser->userMeta->default_school){{ $authUser->userMeta->default_school }}@else{{$schoolinfo->school_id}}@endif">
       <input id="default_school" name="default_school" type="hidden" value="@if(session('school_id')){{ session('school_id')  }}@elseif($authUser->userMeta->default_school){{ $authUser->userMeta->default_school }}@else{{$schoolinfo->school_id}}@endif">

       <div class="col-lg-6 col-xs-12">
           <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
               <label>@lang('adminuser.first_name')<em>*</em></label>
               <input type="text" class="form-control" name="name" id="first_name"
                      value="@if(!empty($userDetail->first_name)){{$userDetail->first_name}}@else{{ old('name') }}@endif"
                      placeholder="@lang('adminuser.first_name')">
           </div>
       </div>
       <div class="col-lg-6 col-xs-12">
           <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
               <label>@lang('adminuser.last_name')<em>*</em></label>
               <input type="text" class="form-control" name="last_name" id="last_name"
                      value="@if(!empty($userDetail->last_name)){{$userDetail->last_name}}@else{{ old('last_name') }}@endif"
                      placeholder="@lang('adminuser.last_name')">
           </div>
       </div>
       <div class="col-lg-6 col-xs-12">
           <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
               <label>@lang('adminuser.email')<em>*</em></label>
               <input type="email" class="form-control"  id="email"
                      value="@if(!empty($userDetail->email)){{$userDetail->email}}@else{{ old('email') }}@endif"
                      name="email" placeholder="@lang('adminuser.email')">
           </div>
       </div>
       <div class="col-lg-6 col-xs-12">
           <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
               <label>@lang('adminuser.password')<em>*</em></label>
               <input type="password" class="form-control" value="" name="password" id="password" autocomplete="off"
                      placeholder="@lang('adminuser.password')">
           </div>
       </div>
       <div class="col-lg-6 col-xs-12">
           <div class="form-group {{ $errors->has('ssn') ? ' has-error' : '' }}">
               <label>@lang('adminuser.ssn')</label>
               <input type="text" class="form-control" id="ssn"
                      value="@if(!empty($userDetail->userMeta->ssn)){{ $userDetail->userMeta->ssn }}@else{{ old('ssn') }}@endif"
                      name="ssn" placeholder="@lang('adminuser.ssn')">
           </div>
       </div>
       <div class="col-lg-6 col-xs-12 {{ $errors->has('gender') ? ' has-error' : '' }}">
           <label>@lang('adminuser.gender')</label>
           <select class="selectpicker" name="gender" id="gender">
               <option value="1"
                       @if(empty($userDetail->userMeta->gender) || ( $userDetail->userMeta->gender == 1) || old('gender') == 1) selected="selected" @endif >@lang('adminuser.male')</option>
               <option value="2"
                       @if( ( !empty($userDetail->userMeta->gender) && ( $userDetail->userMeta->gender == 2) ) || old('gender') == 2 ) )
                       selected="selected" @endif >@lang('adminuser.female')</option>
               <option value="3"
                       @if( ( !empty($userDetail->userMeta->gender) && ( $userDetail->userMeta->gender == 3) ) || old('gender') == 3 ))
                       selected="selected" @endif>@lang('adminuser.other')</option>
           </select>
       </div>
   </div>
   <div class="row">

       <div class="col-lg-6 col-xs-12">
           <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
               <label>@lang('adminuser.phone')<em>*</em></label>
               <input type="text" class="form-control" id="phone"
                      value="@if(!empty($userDetail->userMeta->phone)){{ $userDetail->userMeta->phone }}@else{{ old('phone') }}@endif"
                      name="phone" placeholder="@lang('adminuser.phone')">
           </div>
       </div>
       <div class="col-lg-6 col-xs-12">
           <div class="form-group {{ $errors->has('addressline1') ? ' has-error' : '' }}">
               <label>@lang('adminuser.addressline1')<em>*</em></label>
               <input type="text" class="form-control" id="addressline1"
                      value="@if(!empty($userDetail->userMeta->addressline1)){{ trim($userDetail->userMeta->addressline1)}}@else{{ old('addressline1') }}@endif"
                      name="addressline1" placeholder="@lang('adminuser.addressline1')">
           </div>
       </div>
       <div class="col-lg-6 col-xs-12">
           <div class="form-group" {{ $errors->has('addressline2') ? ' has-error' : '' }}>
               <label>@lang('adminuser.addressline2')</label>
               <input type="text" class="form-control" id="addressline2"
                      value="@if(!empty($userDetail->userMeta->addressline2)){{ $userDetail->userMeta->addressline2 }}@else{{ old('addressline2') }}@endif"
                      name="addressline2" placeholder="@lang('adminuser.addressline2')">
           </div>
       </div>
       <div class="col-lg-6 col-xs-12">
           <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
               <label>@lang('adminuser.city')<em>*</em></label>
               <input type="text" class="form-control" id="city"
                      value="@if(!empty($userDetail->userMeta->city)){{$userDetail->userMeta->city}}@else{{ old('city')}}@endif"
                      name="city" placeholder="@lang('adminuser.city')">
           </div>
       </div>
       <div class="col-lg-6 col-xs-12">
           <div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
               <label>@lang('general.postal_code')<em>*</em></label>
               <input id="postal_code" type="text" class="form-control" id="zip"
                      value="@if(!empty($userDetail->userMeta->zip)){{$userDetail->userMeta->zip}}@else{{ old('zip')}}@endif"
                      name="zip" placeholder="@lang('general.postal_code')">
           </div>
       </div>

   </div>
