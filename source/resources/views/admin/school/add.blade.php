@extends("admin.layout.default")

@if(isset($schoolDetail))
    @if($schoolDetail->schoolName )
        @section('title', $schoolDetail->schoolName)
@else
    @section('title', __('adminschool.title'))
@endif
@else
    @section('title', __('adminschool.title'))
@endif


@section("content")

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                @lang('adminschool.title')
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            @include("error.adminmessage")

            <div class="row">
                <!-- right column -->
                <div class="col-md-6">

                    <!-- general form elements disabled -->
                    <div class="box box-warning">

                        <div class="box-header with-border">
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
                        @if(isset($schoolDetail))
                            <form role="form" action="{{ url('admin/schools/'.$schoolDetail->id.'/edit') }} " method="post" enctype="multipart/form-data">
                            @else
                            <form role="form" action="{{ url('admin/schools/create') }} " method="post" enctype="multipart/form-data">
                        @endif
                                    <!-- /.box-header -->

                        <div class="box-body">

                                {{ csrf_field() }}
                                    <div class="form-group {{ $errors->has('logo') ? ' has-error' : '' }}">
                                        @if(!empty($schoolDetail->logo))
                                         <div>
                                            <img src="{{ url('/uploads/school-logo')}}/{{ $schoolDetail->logo }}" class="img-responsive" width="100px" />
                                            <label class="checkbox-inline"><input type="checkbox" name="remove_logo" value="1">@lang('adminschool.remove_logo')</label>
                                         </div>
                                        @endif
                                        <label class="btn btn-primary btn-file">
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
                                <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">

                                    <label>@lang('adminuser.country')<em>*</em></label>
                                    <select class="form-control" name="country" id="country">
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

                                        <div class="form-group {{ $errors->has('schoolName') ? ' has-error' : '' }}">
                                            <label>@lang('adminschool.schoolname')<em>*</em></label>
                                                <input type="text" class="form-control" name="schoolName" value="@if(isset($schoolDetail->schoolName)){{$schoolDetail->schoolName}}@else{{old('schoolName')}}@endif" placeholder="@lang('adminschool.schoolname')">
                                                @if ($errors->has('schoolName'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('schoolName') }}</strong>
                                                    </span>
                                                @endif
                                        </div>

                                            <div class="form-group {{ $errors->has('school_district') ? ' has-error' : '' }}">

                                                <label>@lang('adminschool.school_district')<em>*</em></label>
                                                <select class="form-control" name="school_district">
                                                    <option value="">@lang('adminschool.selectSchoolDistrict')</option>
                                                    @if(!empty($schoolDisctirict))
                                                        @foreach($schoolDisctirict as $user)
                                                            @if($user->name)
                                                                <option value="{{ $user->id }}" @if(!empty($schoolDetail->school_district) && $schoolDetail->school_district == $user->id) selected="selected" @endif>{{ $user->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </select>
                                                @if ($errors->has('classId'))
                                                    <span class="help-block">
                                            <strong>{{ $errors->first('classId') }}</strong>
                                        </span>
                                                @endif

                                            </div>



                                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">

                                                <label>@lang('adminschool.contact_person_email')<em>*</em></label>

                                                <input type="email" class="form-control" value="@if(isset($schoolDetail->email)){{$schoolDetail->email}}@else{{ old('email')}}@endif" name="email" placeholder="@lang('adminschool.contact_person_email')">
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                                @endif

                                            </div>


                                            <div class="form-group {{ $errors->has('registrationNo') ? ' has-error' : '' }}">

                                                <label>@lang('adminschool.registrationNo')<em>*</em></label>

                                                <input type="text" class="form-control" value="@if(isset($schoolDetail->registrationNo)){{$schoolDetail->registrationNo}}@else{{ old('registrationNo')}}@endif" name="registrationNo" placeholder="@lang('adminschool.registrationNo')">
                                                @if ($errors->has('registrationNo'))
                                                    <span class="help-block">
                                            <strong>{{ $errors->first('registrationNo') }}</strong>
                                        </span>
                                                @endif
                                            </div>

                                            <div class="form-group {{ $errors->has('WebUrl') ? ' has-error' : '' }}">

                                                <label>@lang('adminschool.weburl')</label>

                                                <input type="text" class="form-control" value="@if(isset($schoolDetail->WebUrl)){{$schoolDetail->WebUrl}}@else{{ old('WebUrl')}}@endif" name="WebUrl" placeholder="@lang('adminschool.weburl')">
                                                @if ($errors->has('WebUrl'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('WebUrl') }}</strong>
                                            </span>
                                                @endif
                                            </div>

                                            <div class="form-group {{ $errors->has('address1') ? ' has-error' : '' }}">

                                                <label>@lang('adminschool.address1')<em>*</em></label>

                                                <input type="text" class="form-control" value="@if(isset($schoolDetail->address1)){{$schoolDetail->address1}}@else{{ old('address1')}}@endif" name="address1" placeholder="@lang('adminschool.address1')">
                                                @if ($errors->has('address1'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('address1') }}</strong>
                                            </span>
                                                @endif
                                            </div>

                                            <div class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">

                                                <label>@lang('adminschool.address2')</label>

                                                <input type="text" class="form-control" value="@if(isset($schoolDetail->address2)){{$schoolDetail->address2}}@else{{ old('address2')}}@endif" name="address2" placeholder="@lang('adminschool.address2')">
                                                @if ($errors->has('address2'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('address2') }}</strong>
                                            </span>
                                                @endif
                                            </div>

                                            <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">

                                                <label>@lang('adminschool.city')<em>*</em></label>

                                                <input type="text" class="form-control" value="@if(isset($schoolDetail->city)){{$schoolDetail->city}}@else{{ old('city') }}@endif" name="city" placeholder="@lang('adminschool.city')">
                                                @if ($errors->has('city'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                                @endif
                                            </div>

                                            <div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">

                                                <label>@lang('general.postal_code')<em>*</em></label>

                                                <input type="text" class="form-control" value="@if(isset($schoolDetail->zip)){{$schoolDetail->zip}}@else{{ old('zip') }}@endif" name="zip" placeholder="@lang('general.postal_code')">
                                                @if ($errors->has('zip'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('zip') }}</strong>
                                            </span>
                                                @endif
                                            </div>

                                            <div class="form-group {{ $errors->has('facebook_url') ? ' has-error' : '' }}">
                                                <label>@lang('general.facebook_url')</label>
                                                <input type="text" class="form-control" value="@if(isset($schoolDetail->facebook_url)){{$schoolDetail->facebook_url}}@else{{ old('facebook_url') }}@endif" name="facebook_url" placeholder="@lang('general.facebook_url')">
                                                @if ($errors->has('facebook_url'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('facebook_url') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('twitter_url') ? ' has-error' : '' }}">
                                                <label>@lang('general.twitter_url')</label>
                                                <input type="text" class="form-control" value="@if(isset($schoolDetail->twitter_url)){{$schoolDetail->twitter_url}}@else{{ old('twitter_url') }}@endif" name="twitter_url" placeholder="@lang('general.twitter_url')">
                                                @if ($errors->has('twitter_url'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('twitter_url') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('instagram_url') ? ' has-error' : '' }}">
                                                <label>@lang('general.instagram_url')</label>
                                                <input type="text" class="form-control" value="@if(isset($schoolDetail->instagram_url)){{$schoolDetail->instagram_url}}@else{{ old('instagram_url') }}@endif" name="instagram_url" placeholder="@lang('general.instagram_url')">
                                                @if ($errors->has('instagram_url'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('instagram_url') }}</strong>
                                            </span>
                                                @endif
                                            </div>


                                        </div>
                                        <!-- /.box-body -->

                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-primary" value="@if(isset($schoolDetail))@lang('adminschool.update')@else @lang('adminschool.add') @endif" name="submit">

                                            <a href="{{ url('admin/schools') }}" class="btn btn-default">@lang('general.cancel')</a>
                                        </div>

                                    </form>

                    </div>
                    <!-- /.box -->
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@section("page-js")
    <script src="{{ asset('assests/admin/userrole/school.js') }}"></script>
    <script>
        jQuery(document).on('change', '#school_logo', function() {
            var input = jQuery(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

            jQuery('#logoname').closest('label').after('<span>'+label+'</span>');
        });

    </script>
@endsection