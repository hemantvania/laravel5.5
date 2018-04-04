<ul class="schoolnav navbar nav nav-pills">
    <li class="{!! setActivePrifix(App::getLocale().'/'. generateUrlPrefix().'/dashboard') !!}"><a href="{{url(App::getLocale().'/'.generateUrlPrefix())}}">@lang('general.welcome') {{Auth::user()->userRoles->rolename }}</a></li>

    <li role="presentation" class="dropdown {!! setActivePrifix(App::getLocale().'/'. generateUrlPrefix().'/users') !!}">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            @lang('sidebarmenu.users') <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="{{url(App::getLocale().'/'. generateUrlPrefix().'/users')}}">@lang('sidebarmenu.users')</a></li>
            <li><a href="{{url(App::getLocale().'/'. generateUrlPrefix().'/users/add')}}">@lang('sidebarmenu.addnew')</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown {!! setActivePrifix(App::getLocale().'/'. generateUrlPrefix().'/schools') !!}">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            @lang('sidebarmenu.schools') <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="{{url(App::getLocale().'/'. generateUrlPrefix().'/schools')}}">@lang('sidebarmenu.schools')</a></li>
            <li><a href="{{url(App::getLocale().'/'. generateUrlPrefix().'/schools/add')}}">@lang('sidebarmenu.addnew')</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown {!! setActivePrifix(App::getLocale().'/'. generateUrlPrefix().'/materials') !!}">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            @lang('sidebarmenu.materials') <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="{{url(App::getLocale().'/'. generateUrlPrefix().'/materials')}}">@lang('sidebarmenu.materials')</a></li>
            <li><a href="{{url(App::getLocale().'/'. generateUrlPrefix().'/materials/add')}}">@lang('sidebarmenu.addnew')</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown {!! setActivePrifix(App::getLocale().'/'. generateUrlPrefix().'/reports') !!}">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            @lang('sidebarmenu.reports') <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
                <li><a href="{{url(App::getLocale().'/'. generateUrlPrefix().'/reports/students')}}">@lang('sidebarmenu.student')</a></li>
                <li><a href="{{url(App::getLocale().'/'. generateUrlPrefix().'/reports/teachers')}}">@lang('sidebarmenu.teacher')</a></li>
                <li><a href="{{url(App::getLocale().'/'. generateUrlPrefix().'/reports/schooladmins')}}">@lang('sidebarmenu.schooladmin')</a></li>
                <li><a href="{{url(App::getLocale().'/'. generateUrlPrefix().'/reports/schooldistrcts')}}">@lang('sidebarmenu.schooldiscrict')</a></li>
        </ul>
    </li>
</ul>
