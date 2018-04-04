@extends("admin.layout.default")

@section('title', __('admindashboard.title'))

@section("page-css")
  <link rel="stylesheet" href="{{ asset('assests/admin/bower_components/jvectormap/jquery-jvectormap.css') }}">
@endsection

@section("content")
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @lang('general.welcome')
        <!-- <small>Version 2.0</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">Dashboard</div>

            <div class="panel-body">
              @if (session('status'))
                <div class="alert alert-success">
                  {{ session('status') }}
                </div>
              @endif

              You are logged in!
            </div>
          </div>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection


@section("page-js")

  <!-- Sparkline -->
  <script src="{{ asset('assests/admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
  <!-- jvectormap  -->
  <script src="{{ asset('assests/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
  <script src="{{ asset('assests/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>


  <!-- ChartJS -->
  <script src="{{ asset('assests/admin/bower_components/Chart.js/Chart.js') }}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{ asset('assests/admin/dist/js/pages/dashboard2.js') }}"></script>

@endsection