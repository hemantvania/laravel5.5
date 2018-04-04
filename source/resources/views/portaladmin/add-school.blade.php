@extends('layouts.vdesk')
@section("page-css")
@endsection
@section('content')
    @include("error.message")
    <section class="content-wrapper">
        <div class="container-fluid inner-contnet-wrapper">
            <div class="tab-wrapper">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 user-details">@include("comman.admin-nav")</div>
                    @include("comman.navigation")
                </div>
            </div>

        </div>
    </section>
    <section class="content-wrapper">
        <div class="container-fluid">
            <div class="row">

                <div class="scroll-main-wrapper2">
                    <div class="col-md-12">
                        <h3 class="box-title">
                            @if(isset($schoolDetail))
                                @if($schoolDetail->schoolName )
                                    {{$schoolDetail->schoolName }}
                                @endif
                            @else
                                @lang('adminschool.addschool')
                            @endif
                        </h3>
                    </div>
                    <form id="addedit_school" role="form" @if(isset($schoolDetail)) action="{{ url(App::getLocale().'/'. generateUrlPrefix().'/schools/'.$schoolDetail->id.'/update') }}" @else action="{{ url(App::getLocale().'/'. generateUrlPrefix().'/schools/add') }}" @endif method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input id="hid_user_id" name="user_id" type="hidden" value="@if(isset($userDetail)){{$userDetail->id}}@endif">
                        <input id="hid_country" name="country" type="hidden"value="@if(!empty($authUser->userMeta->country)){{$authUser->userMeta->country}}@endif">

                        <div class="col-lg-3 col-xs-12">
                            <h4 class="personal-info-header">@lang('adminschool.label_school_logo')</h4>
                            <div class="picture-upload-cust">
                                @if(!empty($schoolDetail->logo))
                                    <img src="{{url($schoolDetail->logo)}}" style="max-width: 100%; display: block;" />
                                    <label class="checkbox-inline"><input type="checkbox" name="remove_logo" value="1">@lang('adminschool.remove_logo')</label>
                                  @else
                                    <img src="{{ asset('img/school_logo_placeholder.png') }}"  style="max-width: 100%; display: block;" />
                                @endif
                            </div>
                            <div class="browse-picture-cust">
                                <label class="btn btn-vdesk btn-file">
                                    <span id="logoname">@lang('adminschool.uploadlogo')...</span>
                                    <input id="school_logo" type="file" class="form-control" name="logo" style="display:none;" >
                                </label>
                                <input id="current_logo" type="hidden" name="current_logo" value="@if(isset($schoolDetail->logo)){{$schoolDetail->logo}}@else{{old('logo')}}@endif" >
                                @if ($errors->has('logo'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('logo') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-9 col-xs-12">
                            <div class="row">
                                <div class="col-lg-4 col-xs-12">
                                    <div class="row">
                                        <h4 class="personal-info-header">@lang('general.label_school_details')</h4>
                                        <div class="form-group col-xs-12 {{ $errors->has('country') ? ' has-error' : '' }}">
                                            <label>@lang('adminuser.country')<em>*</em></label>
                                            <select class="selectpicker" name="country" id="country">
                                                <option value="">@lang('adminuser.selectcountry')</option>
                                                @if(!empty($countrieList))
                                                    @foreach($countrieList as $country)
                                                        <option value="{{$country->id }}"
                                                                @if(!empty($schoolDetail->country))
                                                                {{$country->id }}
                                                                @if($country->id == $schoolDetail->country)
                                                                selected="selected"
                                                                @endif
                                                                @endif >{{$country->countryname}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('country'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('country') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group col-xs-12 {{ $errors->has('schoolName') ? ' has-error' : '' }}">
                                            <label>@lang('adminschool.schoolname')<em>*</em></label>
                                            <input type="text" class="form-control" name="schoolName" value="@if(isset($schoolDetail->schoolName)){{$schoolDetail->schoolName}}@else{{old('schoolName')}}@endif" placeholder="@lang('adminschool.schoolname')">
                                            @if ($errors->has('schoolName'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('schoolName') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                       
                                        <div class="form-group col-xs-12 {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label>@lang('adminschool.contact_person_email')<em>*</em></label>
                                            <input type="email" class="form-control" value="@if(isset($schoolDetail->email)){{$schoolDetail->email}}@else{{ old('email')}}@endif" name="email" placeholder="@lang('adminschool.contact_person_email')">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group col-xs-12  {{ $errors->has('registrationNo') ? ' has-error' : '' }}">
                                            <label>@lang('adminschool.registrationNo')<em>*</em></label>
                                            <input type="text" class="form-control" value="@if(isset($schoolDetail->registrationNo)){{$schoolDetail->registrationNo}}@else{{ old('registrationNo')}}@endif" name="registrationNo" placeholder="@lang('adminschool.registrationNo')">
                                            @if ($errors->has('registrationNo'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('registrationNo') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xs-12">
                                    <h4 class="personal-info-header">@lang('general.label_address_details')</h4>
                                    <div class="form-group col-xs-12 {{ $errors->has('address1') ? ' has-error' : '' }}">
                                        <label>@lang('adminschool.address1')<em>*</em></label>
                                        <input type="text" class="form-control" value="@if(isset($schoolDetail->address1)){{$schoolDetail->address1}}@else{{ old('address1')}}@endif" name="address1" placeholder="@lang('adminschool.address1')">
                                        @if ($errors->has('address1'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('address1') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-xs-12 {{ $errors->has('address2') ? ' has-error' : '' }}">
                                        <label>@lang('adminschool.address2')</label>
                                        <input type="text" class="form-control" value="@if(isset($schoolDetail->address2)){{$schoolDetail->address2}}@else{{ old('address2')}}@endif" name="address2" placeholder="@lang('adminschool.address2')">
                                        @if ($errors->has('address2'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('address2') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-xs-12 {{ $errors->has('city') ? ' has-error' : '' }}">
                                        <label>@lang('adminschool.city')<em>*</em></label>
                                        <input type="text" class="form-control" value="@if(isset($schoolDetail->city)){{$schoolDetail->city}}@else{{ old('city') }}@endif" name="city" placeholder="@lang('adminschool.city')">
                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-xs-12 {{ $errors->has('zip') ? ' has-error' : '' }}">
                                        <label>@lang('general.postal_code')<em>*</em></label>
                                        <input type="text" class="form-control" value="@if(isset($schoolDetail->zip)){{$schoolDetail->zip}}@else{{ old('zip') }}@endif" name="zip" placeholder="@lang('general.postal_code')">
                                        @if ($errors->has('zip'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('zip') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xs-12">
                                    <h4 class="personal-info-header">@lang('general.label_other_details')</h4>
                                    <div class="form-group col-xs-12 {{ $errors->has('WebUrl') ? ' has-error' : '' }}">
                                        <label>@lang('adminschool.weburl')</label>
                                        <input type="text" class="form-control" value="@if(isset($schoolDetail->WebUrl)){{$schoolDetail->WebUrl}}@else{{ old('WebUrl')}}@endif" name="WebUrl" placeholder="@lang('adminschool.weburl')">
                                        @if ($errors->has('WebUrl'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('WebUrl') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-xs-12 {{ $errors->has('facebook_url') ? ' has-error' : '' }}">
                                        <label>@lang('general.facebook_url')</label>
                                        <input type="text" class="form-control" value="@if(isset($schoolDetail->facebook_url)){{$schoolDetail->facebook_url}}@else{{ old('facebook_url') }}@endif" name="facebook_url" placeholder="@lang('general.facebook_url')">
                                        @if ($errors->has('facebook_url'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('facebook_url') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-xs-12  {{ $errors->has('twitter_url') ? ' has-error' : '' }}">
                                        <label>@lang('general.twitter_url')</label>
                                        <input type="text" class="form-control" value="@if(isset($schoolDetail->twitter_url)){{$schoolDetail->twitter_url}}@else{{ old('twitter_url') }}@endif" name="twitter_url" placeholder="@lang('general.twitter_url')">
                                        @if ($errors->has('twitter_url'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('twitter_url') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-xs-12 {{ $errors->has('instagram_url') ? ' has-error' : '' }}">
                                        <label>@lang('general.instagram_url')</label>
                                        <input type="text" class="form-control" value="@if(isset($schoolDetail->instagram_url)){{$schoolDetail->instagram_url}}@else{{ old('instagram_url') }}@endif" name="instagram_url" placeholder="@lang('general.instagram_url')">
                                        @if ($errors->has('instagram_url'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('instagram_url') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-xs-12 {{ $errors->has('default_language') ? ' has-error' : '' }}">
                                        <label>@lang('general.select_language')<em>*</em></label>
                                        <select id="default_language" class="selectpicker" name="default_language">
                                            <option value="">@lang('general.select_language')</option>
                                            @if(config('language.option'))
                                                @foreach(config('language.option') as $key=>$value)
                                                    <option value="{{$key}}" @if(old('default_language') == $key) selected @endif @if(!empty($schoolDetail->language) && $schoolDetail->language == $key) selected @endif >{{$value}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('default_language'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('default_language') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    <div class="form-group pull-right">
                                        <button type="submit" name="submit" class="btn btn-vdesk">@if(isset($schoolDetail))@lang('adminschool.update')@else @lang('adminschool.add') @endif</button>
                                        <a class="btn btn-default btn-vdesk-light" href="{{ url(App::getLocale().'/'. generateUrlPrefix().'/schools') }}">@lang('general.cancel')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
    </section>
@endsection
