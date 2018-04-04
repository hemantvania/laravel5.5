@extends("admin.layout.default")

@section('title', __('adminuserrole.title'))

@section("page-css")
    <link rel="stylesheet" href="{{ asset('assests/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section("content")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
		
            <h1>
                @lang('adminuserrole.title')
                <small>List</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            @include("error.adminmessage")

            <div class="row">
                <div class="col-xs-12">


                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">@lang('adminuserrole.title')</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th>User Role Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                     </tr>
                                </thead>

                                <tbody>
                                @if($list)
                                    @foreach($list as $role)
                                    <tr id="{{$role->id}}">
                                        <td>@if($role->rolename) {{$role->rolename}} @endif</td>
                                        <td>@if($role->isactive == 1) Active @else Deactive @endif</td>
                                        <td>
                                            @if(isset($role->deleted_at))
                                                <a href="javascript:void(0);" data-index="{{$role->id}}" class="restore-userrole btn btn-primary"><i class="fa fa-undo"></i>@lang('adminuserrole.restore')</a>
                                            @else
                                                <a href="{{ URL("/admin/userrole/".$role->id."/edit") }}" class="btn btn-warning"><i class="fa fa-edit"></i>@lang('adminuserrole.edit')</a>
                                                <a href="javascript:void(0);" data-index="{{$role->id}}" class="remove-userrole btn btn-danger"><i class="fa fa-remove"></i>@lang('adminuserrole.delete')</a>
                                            @endif
                                        <!-- URL("/admin/userrole/".$role->id."/delete") -->
                                    </tr>
                                    @endforeach
                                 @else
                                    <tr>
                                        <td colspan="3">@lang('adminuserrole.norecords')</td>
                                    </tr>
                                 @endif
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>User Role Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@section("page-js")

    <script src="{{ asset('assests/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assests/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assests/admin/userrole/userrole.js') }}"></script>
@endsection