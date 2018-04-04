<ul class="schoolnav navbar nav nav-pills">
    <li class="{!! setActivePrifix(App::getLocale().'/'. generateUrlPrefix().'/dashboard') !!}"><a href="{{ generateDashboardLink(Auth::user()->userrole) }}">@lang('general.welcome') {{Auth::user()->userRoles->rolename }}</a></li>

    <li role="presentation" class="dropdown {!! setActivePrifix(App::getLocale().'/'. generateUrlPrefix().'/schools') !!}">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            @lang('sidebarmenu.schools') <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
              <li><a href="{{ generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/schools')) }}">@lang('sidebarmenu.schools')</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown {!! setActivePrifix(App::getLocale().'/'. generateUrlPrefix().'/teacher') !!}">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            @lang('sidebarmenu.teacher') <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
                <li><a href="{{ generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/teachers')) }}">@lang('sidebarmenu.teacher')</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown {!! setActivePrifix(App::getLocale().'/'. generateUrlPrefix().'/student') !!}">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            @lang('sidebarmenu.student') <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
                <li><a href="{{ generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/students')) }}">@lang('sidebarmenu.student')</a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown {!! setActivePrifix(App::getLocale().'/'. generateUrlPrefix().'/materilasreport') !!}">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            @lang('schooldisctrict.label_materials') <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
                <li><a href="{{ generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/materilasreport')) }}">@lang('schooldisctrict.label_materials')</a></li>
        </ul>
    </li>
</ul>

