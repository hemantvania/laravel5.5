<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('includes.admin.head')
</head>
<body>
<div class="container">
    <header class="row">
        @include('includes.admin.header')
    </header>

    <div id="main" class="row">

        @yield('content')

    </div>

    <footer class="row">
        @include('includes.admin.footer')
    </footer>
</div>
</body>
</html>