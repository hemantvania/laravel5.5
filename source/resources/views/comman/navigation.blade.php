<div class="@if(Auth::user()->userrole == '2') col-lg-3 @else col-lg-4 @endif  col-md-5 @if(Auth::user()->userrole == '3') col-sm-6 @else col-sm-12 @endif col-xs-12 user-details">
    <ul class="pull-right">
      {{--  @if(Auth::user()->userrole == 2)--}}
            <li class="flag-options">
                @if(config('language.option'))
                    <select class="selectpicker" id="language_switcher">
                        @foreach(config('language.option') as $key=>$value)
                            @if($key == 'en')
                                <option class="icon2" data-url="{{generateLangugeUrl($key)}}" @if( Lang::locale() == $key) selected @endif >{{$value}}</option>
                            @elseif($key == 'fi')
                                <option class="icon1" data-url="{{generateLangugeUrl($key)}}" @if( Lang::locale() == $key) selected @endif>{{$value}}</option>
                            @elseif($key == 'sv')
                                <option class="icon3" data-url="{{generateLangugeUrl($key)}}" @if( Lang::locale() == $key) selected @endif>{{$value}}</option>
                            @endif
                        @endforeach
                    </select>
                @endif
            </li>
  {{--  @endif--}}
        <li class="user-option">
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#admin-change-password">@lang('general.changepassword')</a></li>
                            @if(Auth::user()->userrole == '2') {{-- teacher --}}
                                <li><a href="{{ generateLangugeUrl(App::getLocale(),route('teacher.schoolwsitch')) }}">@lang('switch.label_switchschool')</a></li>
                            @endif
                            @if(Auth::user()->userrole == '5') {{-- Portal admin --}}
                                <li><a href="{{ generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/profile')) }}">@lang('general.my_profile')</a></li>
                            @endif
                            @if(Auth::user()->userrole == '6') {{-- school admin  --}}
                                <li><a href="{{ generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/profile')) }}">@lang('general.my_profile')</a></li>
                            @endif
                            @if(Auth::user()->userrole == '4'){{-- school District --}}
                                <li><a href="{{ generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/profile')) }}">@lang('general.my_profile')</a></li>
                            @endif
    <li>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            @lang('general.logout')
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>
</ul>
</li>
</ul>
</li>
</ul>
</div>

