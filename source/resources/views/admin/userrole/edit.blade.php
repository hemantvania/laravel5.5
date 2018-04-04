@extends("admin.layout.default")

@section('title', __('adminuserrole.title'))

@section("content")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @lang('adminuserrole.title')
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Forms</a></li>
                <li class="active">General Elements</li>
            </ol>
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
                            <h3 class="box-title">{{ $getRecords->rolename != "" ? $getRecords->rolename : "" }}</h3>
                        </div>
                        <form role="form" action="{{ url('admin/userrole/'.$getRecords->id.'/edit') }} " method="post">
                        <!-- /.box-header -->
                        <div class="box-body">


                            {{ csrf_field() }}
                                <!-- text input -->
                                <div class="form-group {{ $errors->has('rolename') ? ' has-error' : '' }}">
                                    <label>Role Name<em>*</em></label>
                                    <input type="text" class="form-control" value="{{$getRecords->rolename}}" name="rolename" placeholder="Role Name">
                                    @if ($errors->has('rolename'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('rolename') }}</strong>
                                        </span>
                                    @endif

                                </div>

                                <!-- select -->
                                <div class="form-group {{ $errors->has('isactive') ? ' has-error' : '' }}">
                                    <label>Status<em>*</em></label>
                                    <select class="form-control" name="isactive">
                                        <option value="">Select Status</option>
                                        <option value="1" {{ $getRecords->isactive === 1 ? "selected" : "" }}>Active</option>
                                        <option value="0" {{ $getRecords->isactive === 0 ? "selected" : "" }}>Deactive</option>
                                    </select>
                                    @if ($errors->has('isactive'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('isactive') }}</strong>
                                        </span>
                                    @endif
                                </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Update" name="submit">

                            <a href="{{ url('admin/userrole') }}" class="btn btn-default">@lang('general.cancel')</a>
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
    <script src="{{ asset('assests/admin/userrole/userrole.js') }}"></script>
@endsection