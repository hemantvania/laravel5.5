<header>
     <div class="top-head vdesk_cyan teacher clearfix">
        <div class="row">
		
            <ul class="language">
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
            </ul>
			
			
        </div>
    </div>
    <div class="logo-section clearfix">
		<div class="cms-menu">
			<ul class="cms-nav-menu">
				<li><a href="{{ generateLangugeUrl( App::getLocale(),url('home'))}}"><span>@lang('general.home')</span></a></li>
				<li><a href="{{ generateLangugeUrl( App::getLocale(),url('faq'))}}"><span>@lang('general.faq')</span></a></li>
				<li><a href="{{ generateLangugeUrl( App::getLocale(),url('about'))}}"><span>@lang('general.aboutus')</span></a></li>
				<li><a href="{{ generateLangugeUrl( App::getLocale(),url('contact'))}}"><span>@lang('general.contactus')</span></a></li>
			</ul>	
		</div>
        <div class="vdesk-logo"> <a href="{{url('/home')}}" title="PULPO Logo"><img src="{{ asset('img/pulpo_logo.png') }}" alt="PULPO Logo" class="img-responsive" /></a> </div>
    </div>
</header>