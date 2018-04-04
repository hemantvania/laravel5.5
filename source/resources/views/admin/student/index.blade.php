@extends("admin.layout.default")

@section('title', __('adminschool.title'))

@section("page-css")
    <link rel="stylesheet" href="{{ asset('assests/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section("content")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
		
            <h1>
                @lang('adminschool.title')
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
                            <h3 class="box-title">@lang('adminschool.title')</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="schoollist" class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th>@lang('adminschool.schoolname')</th>
                                        <th>@lang('adminschool.email')</th>
                                        <th>@lang('adminschool.registrationNo')</th>
                                        <th>@lang('adminschool.address')</th>
                                        <th>@lang('adminschool.weburl')</th>
                                        <th>@lang('adminschool.action')</th>
                                     </tr>
                                </thead>

                                <tbody>
                                @if($list)
                                    @foreach($list as $school)
                                    <tr id="{{$school->id}}">
                                        <td>@if($school->schoolName) {{ $school->schoolName }} @endif</td>
                                        <td>@if($school->email) {{ $school->email }} @endif</td>
                                        <td>@if($school->registrationNo) {{ $school->registrationNo }} @endif</td>
                                        <td>@if($school->address1) {{ $school->address1 }} @endif</td>
                                        <td>@if($school->WebUrl) {{ $school->WebUrl }} @endif</td>
                                        <td>
                                            <a href="{{url('/admin/schools/'.$school->id.'/edit')}}" class="btn btn-warning"><i class="fa fa-edit"></i>@lang('adminschool.edit')</a>
                                            <a href="javascript:void(0)" class="remove-school btn btn-danger" data-index="{{$school->id}}"><i class="fa fa-remove"></i>@lang('adminschool.delete')</a>
                                            @if(isset($school->deleted_at))
                                                <a href="javascript:void(0);" data-index="{{$school->id}}" class="restore-school btn btn-primary"><i class="fa fa-undo"></i>@lang('adminuserrole.restore')</a>
                                            @endif
                                        </td>

                                    </tr>
                                    @endforeach
                                 @else
                                    <tr>
                                        <td colspan="3">@lang('adminschool.norecords')</td>
                                    </tr>
                                  @endif
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>@lang('adminschool.schoolname')</th>
                                        <th>@lang('adminschool.email')</th>
                                        <th>@lang('adminschool.registrationNo')</th>
                                        <th>@lang('adminschool.address')</th>
                                        <th>@lang('adminschool.weburl')</th>
                                        <th>@lang('adminschool.action')</th>
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
    <script type="text/javascript" src="{{ asset('assests/admin/school/school.js') }}"></script>
@endsection