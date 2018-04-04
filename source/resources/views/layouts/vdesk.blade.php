<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{-- remove underline from phone in IE edge --}}
    <meta name="format-detection" content="telephone=no"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'vDESK') }}</title>
    <!-- Bootstrap v3.3.7 CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('plugins/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/plugins_select2.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vdesk.css') }}">
@yield('page-css')
<!-- Media Query CSS -->
    <link rel="stylesheet" href="{{ asset('css/media-query.css') }}">
    <!-- favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon32x32.ico') }}">
</head>
<!-- Start Body Tag-->
<body>
<div class="wrapper">
    <div class="main-content-wrapper">
        @if (Auth::guest())
            @include("layouts.header-login")
        @else
            @include("layouts.header")
        @endif

        @yield('content')
        <div id="push"></div>
    </div>
    @include("layouts.footer")
</div>
<div id="app"></div>
<!-- REQUIRED JS SCRIPTS -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('plugins/socket.io/socket.io-1.4.5.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/plugins_select2_select2.full.min.js')}}"></script>
<script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.min.js')}}"></script>
<script>
    var vdeskLanguage = jQuery('html').attr('lang');
    var sockethost = "{{ env('REDIS_URI_HOST') }}";
    var serverhost = '{{strstr($_SERVER['HTTP_HOST'],':', true)}}';
    var socket = io.connect("http://202.131.103.44:8122");
    //alert(sockethost);
</script>
<script src="{{ asset('js/custom.js')}}"></script>
@yield('scripts')
<script type="text/javascript">
    var configtime ='{{config('session.lifetime')}}';
    var timeout = ( configtime * 60) * 1000 ;
    setTimeout(function() {
        //reload on current page
        jQuery("#logout-form").submit();
    }, timeout);
</script>
</body>
<!-- End Body Tag-->
</html>