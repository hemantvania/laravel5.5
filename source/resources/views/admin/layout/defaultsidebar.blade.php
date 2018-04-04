<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      {{--<div class="user-panel">
         <div class="pull-left image jm">
          <img src="{{ asset('assests/admin/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          @if (Auth::check())
            <p> {{ Auth::user()->name }}</p>
          @endif
        </div>
      </div>--}}

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

        <li class="header" style="text-transform: uppercase;">Welcome {{ Auth::user()->userRoles->rolename }}</li>

        <li>
          <a href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/dashboard')) }}">
            <i class="fa fa-dashboard"></i> <span>@lang('sidebarmenu.dashboard')</span>
          </a>
        </li>

        @if(Auth::user()->userrole != '6')
        <li class="treeview {!! setActivePrifix(['admin/'.App::getLocale().'/users']) !!}">
          <a href="#">
            <i class="fa fa-users"></i> <span>@lang('sidebarmenu.users')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{!! setActive('admin/'.App::getLocale().'/users') !!}"><a href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/users')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.users')</a></li>
            <li class="{!! setActive('admin/'.App::getLocale().'/users/create') !!}"><a href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/users/create')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.addnew')</a></li>
          </ul>
        </li>

        <li class="treeview {!! setActivePrifix(['admin/'.App::getLocale().'/schools']) !!}">
          <a href="#">
            <i class="fa fa-university"></i> <span>@lang('sidebarmenu.schools')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a class="{!! setActive('admin/'.App::getLocale().'/schools') !!}" href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/schools')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.schools')</a></li>
            <li><a class="{!! setActive('admin/'.App::getLocale().'/schools/create') !!}" href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/schools/create')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.addnew')</a></li>
          </ul>
        </li>
          @if(Auth::user()->userrole == 5 || Auth::user()->userrole == 1 )
          <li class="treeview">
            <a href="#">
              <i class="fa fa-list-alt"></i><span>@lang('sidebarmenu.content')</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-hand-o-right"></i><span>@lang('sidebarmenu.reports')</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
          </li>
          @endif

          <li class="treeview {!! setActivePrifix(['admin/'.App::getLocale().'/materials']) !!}">
            <a href="#">
              <i class="fa fa-list-alt"></i> <span>@lang('sidebarmenu.content')</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
              <li><a class="{!! setActive('admin/'.App::getLocale().'/materials/category') !!}" href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/materials/category')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.category')</a></li>
             <li><a class="{!! setActive('admin/'.App::getLocale().'/materials') !!}" href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/materials')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.content')</a></li>
              <li><a class="{!! setActive('admin/'.App::getLocale().'/materials/create') !!}" href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/materials/create')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.addnew')</a></li>
            </ul>
          </li>

        @endif
        @if(Auth::user()->userrole == 6 || Auth::user()->userrole == 1 )
          <li class="treeview {!! setActivePrifix(['admin/'.App::getLocale().'/schools/teachers']) !!}">
            <a href="#">
              <i class="fa fa-users"></i> <span>@lang('sidebarmenu.teacher')</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
              <li><a class="{!! setActive('admin/'.App::getLocale().'/schools/teachers') !!}" href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/schools/teachers')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.teacher')</a></li>
              @if(Auth::user()->userrole != 1)
              <li class="{!! setActive('admin/'.App::getLocale().'/schools/teachers/create') !!}"><a href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/schools/teachers/create')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.addnew')</a></li>
              @else
                <li class="{!! setActive('admin/'.App::getLocale().'/users/create') !!}"><a href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/users/create')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.addnew')</a></li>
              @endif
            </ul>
          </li>
          <li class="treeview" {!! setActivePrifix(['admin/'.App::getLocale().'/schools/students']) !!}>
            <a href="#">
              <i class="fa fa-users"></i> <span>@lang('sidebarmenu.student')</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
              <li><a class="{!! setActive('admin/'.App::getLocale().'/schools/students') !!}" href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/schools/students')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.student')</a></li>
              @if(Auth::user()->userrole != 1)
                <li class="{!! setActive('admin/'.App::getLocale().'/schools/students/create') !!}"><a href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/schools/students/create')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.addnew')</a></li>
              @else
                <li class="{!! setActive('admin/'.App::getLocale().'/users/create') !!}"><a href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/users/create')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.addnew')</a></li>
              @endif
            </ul>
          </li>
          <li class="treeview {!! setActivePrifix(['admin/'.App::getLocale().'/classes']) !!}">
            <a href="#">
              <i class="fa fa-address-card"></i> <span>@lang('sidebarmenu.classes')</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
              <li><a class="{!! setActive('admin/'.App::getLocale().'/classes') !!}" href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/classes')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.classes')</a></li>
              <li><a class="{!! setActive('admin/'.App::getLocale().'/classes/create') !!}" href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/classes/create')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.addnew')</a></li>
            </ul>
          </li>
        @endif

        @if(Auth::user()->userrole == 1)
        <li class="treeview {!! setActivePrifix(['admin/'.App::getLocale().'/userrole']) !!}">
          <a href="#">
            <i class="fa fa-user-o"></i> <span>@lang('sidebarmenu.roles')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{!! setActive('admin/'.App::getLocale().'/userrole') !!}"><a href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/userrole')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.roles')</a></li>
            <li class="{!! setActive('admin/'.App::getLocale().'/userrole/add') !!}"><a href="{{ generateLangugeUrlAdmin(App::getLocale(),url('/userrole/add')) }}"><i class="fa fa-circle-o"></i> @lang('sidebarmenu.addnew')</a></li>
          </ul>
        </li>
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>