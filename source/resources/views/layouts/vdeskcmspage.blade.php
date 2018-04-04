<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
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
	
     @include("layouts.header-cmspage")
    

    @yield('content')
        <div id="push"></div>
    </div>
    @include("layouts.footer")

</div>
<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ url('js/plugins_select2_select2.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
<script>
    var vdeskLanguage = jQuery('html').attr('lang');
</script>
<script src="{{ url('js/custom.js')}}"></script>
@yield('scripts')
</body>
<!-- End Body Tag-->
</html>