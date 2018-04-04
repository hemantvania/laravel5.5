<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title') | VDesk </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


    <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('assests/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assests/admin/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('assests/admin/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assests/admin/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('assests/admin/dist/css/skins/_all-skins.min.css') }}">

  <link rel="stylesheet" href="{{ asset('assests/admin/admin-custom.css') }}">
  @yield("page-css")

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition skin-black-light sidebar-mini">
	<div class="wrapper">
		<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/admin/dashboard') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>V</b>Desk</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>V</b>Desk</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

            @if(config('language.option'))
                @foreach(config('language.option') as $key=>$value)
                    @if(isset($value))
                        <li><a href="{{generateLangugeUrl($key)}}" title="{{$value}}" class="language-switcher" data-id="{{$key}}">
                                @if($key == 'en')
                                    <img src="{{ asset('img/english-flag.jpg') }}" alt="english-flag" />
                                @elseif($key == 'fi')
                                    <img src="{{ asset('img/finnish-flag.jpg') }}" alt="finnish-flag" />
                                @elseif($key == 'sv')
                                    <img src="{{ asset('img/swedish-flag.jpg') }}" alt="swedish-flag" />
                                @endif
                            </a></li>
                    @endif
                @endforeach
            @endif

            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    {{-- <img src="{{ asset('assests/admin/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">--}}
                    @if (Auth::check())
                        <span class="hidden-xs"> {{ Auth::user()->name }}</span>
                    @endif
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                {{-- <li class="user-header">
                   <img src="{{ asset('assests/admin/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

                    @if (Auth::check())
                    <p>{{ Auth::user()->name }}</p>
                    @endif

                </li>--}}

                <!-- Menu Footer-->
                    <li class="user-footer">
                        @if(!empty(Auth::user()->id))
                            {{--<div class="pull-left">
                                <a href="{{ url('/admin/users/'.Auth::user()->id.'/edit') }}" class="btn btn-default btn-flat">Profile</a>
                            </div>--}}
                            <div class="pull-left">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#admin-change-password">Change Password</button>
                            </div>
                        @endif
                        <div class="pull-right">
                            <a href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/logout')) }}" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

</nav>
</header>