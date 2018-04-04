<header>
    <div class="top-head vdesk_lightgray clearfix">
        <div class="row">
            <ul class="language">
                @if(config('language.option'))
                    @foreach(config('language.option') as $key=>$value)
                        @if(isset($value))
                            <li><a href="{{generateLangugeUrl($key)}}" title="{{$value}}" class="language-switcher @if($loop->index == 0) active @endif" data-id="{{$key}}">
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
            </ul>
        </div>
    </div>
    <div class="logo-section clearfix">
        <div class="school-logo"> <a href="{{url('/home')}}" title="School Logo"><img src="{{ asset('img/school-logo.jpg') }}" alt="School Logo" class="img-responsive" /></a> </div>
        <div class="vdesk-logo"> <a href="{{url('/home')}}" title="PULPO Logo"><img src="{{ asset('img/pulpo_logo.png') }}" alt="PULPO Logo" class="img-responsive" /></a> </div>
    </div>
</header>
