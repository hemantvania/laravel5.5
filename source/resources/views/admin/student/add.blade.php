@extends("admin.layout.default")

@section('title', __('adminschool.title'))

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
                            <form role="form" action="{{ url('admin/schools/'.$schoolDetail->id.'/edit') }} " method="post">
                        @else
                            <form role="form" action="{{ url('admin/schools/create') }} " method="post">
                        @endif
                        <!-- /.box-header -->

                        <div class="box-body">


                            {{ csrf_field() }}


                                <div class="form-group {{ $errors->has('schoolName') ? ' has-error' : '' }}">

                                    <label>@lang('adminschool.schoolname')</label>

                                    <input type="text" class="form-control" name="schoolName" value="@if(isset($schoolDetail->schoolName)){{$schoolDetail->schoolName}} @else {{ old('schoolName') }} @endif" placeholder="@lang('adminschool.schoolname')">
                                    @if ($errors->has('schoolName'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('schoolName') }}</strong>
                                        </span>
                                    @endif

                                </div>


                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">

                                    <label>@lang('adminschool.email')</label>

                                    <input type="email" class="form-control" value="@if(isset($schoolDetail->email)){{$schoolDetail->email}} @else {{ old('email') }} @endif" name="email" placeholder="@lang('adminschool.email')">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif

                                </div>


                                <div class="form-group {{ $errors->has('registrationNo') ? ' has-error' : '' }}">

                                    <label>@lang('adminschool.registrationNo')</label>

                                    <input type="text" class="form-control" value="@if(isset($schoolDetail->registrationNo)){{$schoolDetail->registrationNo}} @else {{ old('registrationNo') }} @endif" name="registrationNo" placeholder="@lang('adminschool.registrationNo')">
                                    @if ($errors->has('registrationNo'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('registrationNo') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('WebUrl') ? ' has-error' : '' }}">

                                    <label>@lang('adminschool.weburl')</label>

                                    <input type="text" class="form-control" value="@if(isset($schoolDetail->WebUrl)){{$schoolDetail->WebUrl}} @else {{ old('WebUrl') }} @endif" name="WebUrl" placeholder="@lang('adminschool.weburl')">
                                    @if ($errors->has('WebUrl'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('WebUrl') }}</strong>
                                            </span>
                                    @endif
                                </div>

                            <div class="form-group {{ $errors->has('address1') ? ' has-error' : '' }}">

                                <label>@lang('adminschool.address1')</label>

                                <input type="text" class="form-control" value="@if(isset($schoolDetail->address1)){{$schoolDetail->address1}} @else {{ old('address1') }} @endif" name="address1" placeholder="@lang('adminschool.address1')">
                                @if ($errors->has('address1'))
                                    <span class="help-block">
                                                <strong>{{ $errors->first('address1') }}</strong>
                                            </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">

                                <label>@lang('adminschool.address2')</label>

                                <input type="text" class="form-control" value="@if(isset($schoolDetail->address2)){{$schoolDetail->address2}} @else {{ old('address2') }} @endif" name="address2" placeholder="@lang('adminschool.address2')">
                                @if ($errors->has('address2'))
                                    <span class="help-block">
                                                <strong>{{ $errors->first('address2') }}</strong>
                                            </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">

                                <label>@lang('adminschool.city')</label>

                                <input type="text" class="form-control" value="@if(isset($schoolDetail->city)){{$schoolDetail->city}} @else {{ old('city') }} @endif" name="city" placeholder="@lang('adminschool.city')">
                                @if ($errors->has('city'))
                                    <span class="help-block">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">

                                <label>@lang('adminschool.state')</label>

                                <input type="text" class="form-control" value="@if(isset($schoolDetail->state)){{$schoolDetail->state}} @else {{ old('state') }} @endif" name="state" placeholder="@lang('adminschool.state')">
                                @if ($errors->has('state'))
                                    <span class="help-block">
                                                <strong>{{ $errors->first('state') }}</strong>
                                            </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">

                                <label>@lang('adminschool.zip')</label>

                                <input type="text" class="form-control" value="@if(isset($schoolDetail->zip)){{$schoolDetail->zip}} @else {{ old('zip') }} @endif" name="zip" placeholder="@lang('adminschool.zip')">
                                @if ($errors->has('zip'))
                                    <span class="help-block">
                                                <strong>{{ $errors->first('zip') }}</strong>
                                            </span>
                                @endif
                            </div>


                        </div>
                        <!-- /.box-body -->

                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value=" @if(isset($schoolDetail)) @lang('adminschool.update') @else @lang('adminschool.add') @endif" name="submit">
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
@endsection