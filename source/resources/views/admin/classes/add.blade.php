@extends("admin.layout.default")

@if(isset($classDetail))
    @if($classDetail->classesName )
        @section('title', $classDetail->classessName)
    @else
        @section('title', __('adminclasses.title'))
    @endif
@else
    @section('title', __('adminclasses.title'))
@endif


@section("content")

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                @lang('adminclasses.title')
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

                                @if(isset($classDetail))
                                    @if($classDetail->className )
                                        {{$classDetail->className }}
                                    @endif
                                @else
                                    @lang('adminclasses.addclass')
                                @endif


                            </h3>
                        </div>
                        @if(isset($classDetail))
                            <form role="form" action="{{ url('admin/classes/'.$classDetail->id.'/edit') }} " method="post">
                        @else
                            <form role="form" action="{{ url('admin/classes/create') }} " method="post">
                        @endif
                        <!-- /.box-header -->

                        <div class="box-body">


                            {{ csrf_field() }}


                                <div class="form-group {{ $errors->has('className') ? ' has-error' : '' }}">

                                    <label>@lang('adminclasses.classname')<em>*</em></label>

                                    <input type="text" class="form-control" name="className" value="@if(isset($classDetail->className)){{$classDetail->className}}@else{{old('className')}}@endif" placeholder="@lang('adminclasses.classname')">
                                    @if ($errors->has('className'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('className') }}</strong>
                                        </span>
                                    @endif

                                </div>
                                <!-- select -->
                                <div class="form-group {{ $errors->has('schoolId') ? ' has-error' : '' }}">
                                    <label>@lang('adminclasses.selectschool')<em>*</em></label>
                                        <select class="form-control" name="schoolId">
                                        <option value="">@lang('adminclasses.selectschool')</option>
                                            @if(!empty($schoolsList))
                                                @foreach($schoolsList as $school)
                                                    @if($school->schoolName)
                                                    <option value="{{ $school->id }}" @if(!empty($classDetail->schoolId) && $classDetail->schoolId == $school->id) selected="selected" @endif>{{ $school->schoolName }}</option>
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
                                <!-- select -->
                                <div class="form-group {{ $errors->has('educationTypeId') ? ' has-error' : '' }}">
                                    <label>@lang('adminclasses.selecteducationtype')<em>*</em></label>
                                        <select class="form-control" name="educationTypeId">
                                    <label>@lang('adminclasses.selecteducationtype')</label>
                                        <option value="">@lang('adminclasses.selecteducationtype')</option>
                                            @if(!empty($edutcationTypeList))
                                                @foreach($edutcationTypeList as $type)
                                                    @if($type->educationName)
                                                    <option value="{{ $type->id }}" @if(!empty($classDetail->educationTypeId) && $classDetail->educationTypeId == $type->id) selected="selected" @endif>{{ $type->educationName }}</option>
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

                                <div class="form-group {{ $errors->has('standard') ? ' has-error' : '' }}">

                                    <label>@lang('adminclasses.standard')<em>*</em></label>

                                    <input type="text" class="form-control" name="standard" value="@if(isset($classDetail->standard)){{$classDetail->standard}}@else{{old('standard')}}@endif" placeholder="@lang('adminclasses.standard')">
                                    @if ($errors->has('className'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('standard') }}</strong>
                                        </span>
                                    @endif

                                </div>
                            <div class="form-group {{ $errors->has('class_duration') ? ' has-error' : '' }}">
                                <label>@lang('adminclasses.class_duration')<em>*</em></label>
                                    <select class="form-control" name="class_duration">
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

                            <div class="form-group {{ $errors->has('class_size') ? ' has-error' : '' }}">
                                <label>@lang('adminclasses.class_size')<em>*</em></label>
                                <select class="form-control" name="class_size">
                                    <option value="">@lang('adminclasses.select_class_size')</option>
                                    @for($s=1; $s<= 50; $s++ )
                                        <option value="{{$s}}"  @if(isset($classDetail) && $classDetail->class_size == $s) selected="selected" @endif >{{$s}}</option>
                                    @endfor
                                </select>

                                @if ($errors->has('class_size'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('class_size') }}</strong>
                                        </span>
                                @endif

                            </div>
                                


                        </div>
                        <!-- /.box-body -->

                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value=" @if(isset($classDetail)) @lang('adminclasses.update') @else @lang('adminclasses.add') @endif" name="submit">

                                <a href="{{ url('admin/classes') }}" class="btn btn-default">@lang('general.cancel')</a>
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