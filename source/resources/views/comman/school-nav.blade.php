<ul class="schoolnav navbar nav nav-pills">
    <li class="{!! setActivePrifix( App::getLocale().'/'.generateUrlPrefix().'/dashboard') !!}"><a href="{{ generateDashboardLink(Auth::user()->userrole) }}">@lang('general.welcome') {{Auth::user()->userRoles->rolename }}</a></li>
    <li role="presentation" class="dropdown {!! setActivePrifix(App::getLocale().'/'.generateUrlPrefix().'/teacher') !!}">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            @lang('sidebarmenu.teacher') <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="{{ generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/teacher')) }}">@lang('sidebarmenu.teacher')</a></li>
            <li><a href="{{ generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/teacher/add')) }}">@lang('sidebarmenu.addnew')</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown {!! setActivePrifix(App::getLocale().'/'.generateUrlPrefix().'/students') !!}">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            @lang('sidebarmenu.student') <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="{{ generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/students')) }}">@lang('sidebarmenu.student')</a></li>
            <li><a href="{{ generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/students/add')) }}">@lang('sidebarmenu.addnew')</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown {!! setActivePrifix(App::getLocale().'/'.generateUrlPrefix().'/classes') !!}">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            @lang('sidebarmenu.classes') <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="{{ generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/classes')) }}">@lang('sidebarmenu.classes')</a></li>
            <li><a href="{{ generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/classes/create')) }}">@lang('sidebarmenu.addnew')</a></li>
           <!-- <li><a href="{{ generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/classes/assign-class')) }}">Assign Class</a></li> -->
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
</ul>
