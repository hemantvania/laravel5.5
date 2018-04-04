<header>
    <div class="top-head vdesk_cyan teacher clearfix">
        <div class="row">
            <ul class="message-option">
                @if(Auth::user()->userrole == 3)
                    <li>
                        <div class="dropdown cq-dropdown dropdown-custom" data-name='statuses'>
                            <button class="open_msg_box btn btn-default btn-sm " type="button" id="dropdown1" data-id="@if(!empty($eDeskList)){{$eDeskList[0]->user_id}} @endif" data-userrole="2" data-name="">
                                @lang('teacher.label_message_to_teacher')
                            </button>
                        </div>
                    </li>
                    <li id="share_screen">
                        <div  class="dropdown cq-dropdown dropdown-custom" data-name='statuses'>
                            <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                @lang('general.takeEConsole')
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdown1">
                                <li><ul id="share_screen_students">
                                        @foreach($eDeskList as $student)
                                            @if($student->id != Auth::user()->id && $student->userrole != 2 )
                                            <li>
                                                <label class="radio-btn">
                                                    <input type="checkbox" value="{{$student->id}}" name="share-screen-student-list" data-title="{{$student->name}}" />{{$student->name}}
                                                </label>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                <li class='text-center cust-border'>
                                    <button type="button"  id="sharescreen" class="btn btn-kirjoita">@lang('teacher.btn_sharescreen')</button>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                @if(Auth::user()->userrole == 2)
                    <li id="chat_students">
                        <div  class="dropdown cq-dropdown dropdown-custom" data-name='statuses'>
                            <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                @lang('teacher.label_send_message')
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdown1">
                                <li><ul id="online_students">
                                        @foreach($students as $student)
                                            <li>
                                                <label class="radio-btn">
                                                    <input type="checkbox" value="{{$student->id}}" name="chat-student-list" data-title="{{$student->fullname}}" />{{$student->fullname}}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class='text-center cust-border'>
                                    <button type="button"  id="startchat" class="btn btn-kirjoita">@lang('teacher.label_write_message')</button>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                @if(Auth::user()->userrole == 2 )
                    @if($screenAuth == 1)
                        <li id="share_screen">
                            <div  class="dropdown cq-dropdown dropdown-custom" data-name='statuses'>
                                <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    @lang('general.takeEConsole')
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdown1">
                                    <li><ul id="share_screen_students">
                                            @foreach($students as $student)
                                                <li>
                                                    <label class="radio-btn">
                                                        <input type="checkbox" value="{{$student->id}}" name="share-screen-student-list" data-title="{{$student->fullname}}" />{{$student->fullname}}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class='text-center cust-border'>
                                        <button type="button"  id="sharescreen" class="btn btn-kirjoita">@lang('teacher.btn_sharescreen')</button>
                                    </li>
                                </ul>
                            </div>
                        </li>
                     @endif
                @endif
            </ul>
            @if(Auth::user()->userrole == 2)
            <ul class="video-option pull-right">
                <li>
                    <button id="play" class="btn-play"><i class="fa fa-play-circle" aria-hidden="true"></i>
                        @lang('teacher.label_hour')</button>
                </li>
                <!--
                --->
                <li>
                    <button class="btn-pause"><i class="fa fa-pause" aria-hidden="true"></i>
                        @lang('teacher.label_break')</button>
                </li>
                <!--
                --->
                <li>
                    <button class="btn-stop"><i class="fa fa-stop" aria-hidden="true"></i>
                        @lang('teacher.label_end')</button>
                </li>
            </ul>
            @endif
        </div>
    </div>
    <div class="logo-section clearfix">
        @if(Auth::user()->userrole != '')
            @if(Auth::user()->userrole == '2')
            <div class="school-logo">
                <a href="{{ generateDashboardLink(Auth::user()->userrole) }}" title="School Logo">
                    @if($logourl != '' )
                        <img src="{{ $logourl }}" alt="School Logo" class="img-responsive" style="height: 55px;"/>
                    @else
                        <img src="{{ asset('img/school_logo_placeholder.png') }}" alt="School Logo" class="img-responsive" style="height: 55px;"/>
                    @endif
                </a>
            </div>
            @endif
        <div class="vdesk-logo"> <a href="{{ generateDashboardLink(Auth::user()->userrole) }}" title="vDESK Logo"><img src="{{ asset('img/pulpo_logo.png') }}" alt="vDESK Logo" class="img-responsive" /></a> </div>
        @else
            <div class="school-logo"> <a href="{{ url('home') }}" title="School Logo"><img src="{{ asset('img/school-logo.jpg') }}" alt="School Logo" class="img-responsive" /></a> </div>
            <div class="vdesk-logo"> <a href="{{ url('home') }}" title="vDESK Logo"><img src="{{ asset('img/pulpo_logo.png') }}" alt="vDESK Logo" class="img-responsive" /></a> </div>
        @endif
    </div>
</header>
<script>

    function getRandomColor() {
        var colorsarr = [
            '#F48274','#FDC913','#7AC29E','#31B0E1','#29B0E4'
        ];
        var randomNumber = Math.floor(Math.random()*colorsarr.length);

        /*var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }*/
        return colorsarr[randomNumber];
    }
</script>