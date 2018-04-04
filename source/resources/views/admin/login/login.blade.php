@extends("admin.layout.blank")

@section('title', __('login.title'))

@section("content")

<div class="login-box">
  <div class="login-logo">
    <a href="{{ url('/admin/login') }}"><b>V </b>Desk</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">

    @include("error.adminmessage")

    <form action="{{ url('/admin/login') }}" method="post">
        {{ csrf_field() }}

        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">

          <input id="email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" autofocus>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

          @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
          @endif

        </div>

        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
          @endif
        </div>

        <div class="row">
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
            <div class="col-xs-8">
                Or <a href="{{ url('/password/reset') }}"> Forgot Password ?</a>
            </div>
            <!-- /.col -->
        </div>
    </form>
      {{--<a href="#">I forgot my password</a><br>--}}
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

@endsection


@section("page-js")
  <script src="{{ asset('assests/admin/login/adminlogin.js') }}"></script>
@endsection