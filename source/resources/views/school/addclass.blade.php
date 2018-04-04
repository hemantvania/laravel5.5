@extends('layouts.vdesk')
@section("page-css")
@endsection
@section('content')
    @include("error.message")
    <section class="content-wrapper">
        <div class="container-fluid inner-contnet-wrapper">
            <div class="tab-wrapper">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 user-details"> @include("comman.school-nav") </div>
                    @include("comman.navigation") </div>
            </div>
        </div>
    </section>
    <section class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="scroll-main-wrapper2">
                    <div class="col-md-12">
                        <h3 class="box-title">
                            @if(isset($classDetail))
                                @if($classDetail->className )
                                    {{$classDetail->className }}
                                @endif
                            @else
                                @lang('adminuser.addsclass')
                            @endif
                        </h3>
                    </div>
                    <form id="addedit_user" role="form" @if(isset($classDetail)) action="{{ url(App::getLocale().'/'. generateUrlPrefix().'/classes/'.$classDetail->id.'/edit') }}" @else action="{{ url(App::getLocale().'/'. generateUrlPrefix().'/classes/create') }} " @endif  method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="col-lg-3 col-xs-12">
                        </div>
                        <div class="row">
                        <div class="col-lg-3 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    <div class="row">
                                        <h4 class="personal-info-header">@lang('general.label_class_details')</h4>
                                        <div class="form-group col-xs-12 {{ $errors->has('className') ? ' has-error' : '' }}">
                                            <label>@lang('adminclasses.classname')<em>*</em></label>
                                            <input type="text" class="form-control" name="className" value="@if(isset($classDetail->className)){{$classDetail->className}}@else{{old('className')}}@endif" placeholder="@lang('adminclasses.classname')">
                                            @if ($errors->has('className'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('className') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group col-xs-12 {{ $errors->has('educationTypeId') ? ' has-error' : '' }}">
                                            <label>@lang('adminclasses.selecteducationtype')<em>*</em></label>
                                            <select class="selectpicker" name="educationTypeId">
                                                <label>@lang('adminclasses.selecteducationtype')</label>
                                                <option value="">@lang('adminclasses.selecteducationtype')</option>
                                                @if(!empty($edutcationTypeList))
                                                    @foreach($edutcationTypeList as $type)
                                                        @if($type->educationName)
                                                            <option value="{{ $type->id }}" @if((!empty($classDetail->educationTypeId) && $classDetail->educationTypeId == $type->id) || old('educationTypeId') ) selected="selected" @endif>{{ $type->educationName }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('educationTypeId'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('educationTypeId') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group col-xs-12 {{ $errors->has('standard') ? ' has-error' : '' }}">
                                            <label>@lang('adminclasses.standard')<em>*</em></label>
                                            <input type="text" class="form-control" name="standard" value="@if(isset($classDetail->standard)){{$classDetail->standard}}@else{{old('standard')}}@endif" placeholder="@lang('adminclasses.standard')">
                                            @if ($errors->has('className'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('standard') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group col-xs-12 {{ $errors->has('class_duration') ? ' has-error' : '' }}">
                                            <label>@lang('adminclasses.class_duration')<em>*</em></label>
                                            <select class="selectpicker" name="class_duration">
                                                <option value="">@lang('adminclasses.select_class_duration')</option>
                                                @for($i=0; $i<= 60; $i+=5 )
                                                    @if($i > 0 ){
                                                    <option value="{{$i}}" @if(isset($classDetail) && $classDetail->class_duration == $i) selected="selected" @endif >{{$i}} Minutes</option>
                                                    @endif
                                                @endfor
                                            </select>
                                            @if ($errors->has('class_duration'))
                                                <span class="help-block">
                                                  <strong>{{ $errors->first('class_duration') }}</strong>
                                              </span>
                                            @endif
                                        </div>
                                        <div class="form-group col-xs-12 {{ $errors->has('class_size') ? ' has-error' : '' }}">
                                            <label>@lang('adminclasses.class_size')<em>*</em></label>
                                            <select class="selectpicker" name="class_size">
                                                <option value="">@lang('adminclasses.select_class_size')</option>
                                                @for($s=1; $s<= 50; $s++ )
                                                    <option value="{{$s}}"  @if((isset($classDetail) && $classDetail->class_size == $s) || old('class_size')) selected="selected" @endif >{{$s}}</option>
                                                @endfor
                                            </select>
                                            @if ($errors->has('class_size'))
                                                <span class="help-block">
                                                  <strong>{{ $errors->first('class_size') }}</strong>
                                              </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    <div class="row">
                                        <h4 class="personal-info-header">@lang('general.label_other_details')</h4>
                                        <div class="form-group col-xs-12 {{ $errors->has('schoolId') ? ' has-error' : '' }}">
                                            <label>@lang('adminclasses.selectschool')<em>*</em></label>
                                            <select class="selectpicker" name="schoolId">
                                                <option disabled="disabled" value="">@lang('adminclasses.selectschool')</option>
                                                @if(!empty($schoolsList))
                                                    @foreach($schoolsList as $school)
                                                        @if($school->schoolName)
                                                            <option value="{{ $school->id }}" @if((!empty($classDetail->schoolId) && $classDetail->schoolId == $school->id) || old('schoolId') ) selected="selected" @endif>{{ $school->schoolName }}</option>
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
                                         <div class="form-group col-xs-12 {{ $errors->has('user_id') ? ' has-error' : '' }}">
                                            <label>@lang('general.selectteachers')</label>
                                            <select class="selectpicker" name="user_id[]" multiple >
                                                <option value="" disabled="disabled">@lang('general.selectteacher')</option>
                                                @if(!empty($teachers))
                                                    @foreach($teachers as $teacher)
                                                        <option value="{{ $teacher->userId }}" @if(!empty($assignedTeachers)) @if(in_array($teacher->userId, $assignedTeachers )) selected="selected" @endif @else @if(!empty(old('user_id'))) @if($teacher->userId == old('schoolId')) selected="selected" @endif @endif @endif >{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('user_id'))
                                                <span class="help-block">
                                                  <strong> {{ $errors->first('user_id') }}</strong>
                                              </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group pull-right">
                                <button type="submit" name="submit" class="btn btn-vdesk">@if(isset($classDetail)) @lang('adminclasses.update') @else @lang('adminclasses.add') @endif</button>
                                <a href="{{ url(App::getLocale().'/'. generateUrlPrefix().'/classes') }}" class="btn btn-default btn-vdesk-light">@lang('general.cancel')</a>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-3 col-xs-12">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection 