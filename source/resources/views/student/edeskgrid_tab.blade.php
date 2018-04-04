<div class="pulpetit-main">
    <div class="row">
        @if(count($eDeskList) > 0)
        @foreach( $eDeskList as $desk)

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" >
                <div id="student_{{$desk->user_id}}" class="pulpetit-desk @if(($desk->is_commu_on || $loop->first ) && $desk->is_active ) active @else inactive @endif" >
                    <div class="desk-head">
                        @if($loop->first) @lang('general.label_teacher')
                        @else @lang('teacher.label_edesk')
                            {{$desk->sequence}}
                        @endif:
                            {{ setStringLength($desk->name, 20) }} </div>
                    <ul class="desk-action  @if(Auth::user()->id == $desk->user_id) self-desk @endif">
                        <li>
                            <a href="javascript:void(0)" class="@if(Auth::user()->id != $desk->user_id) open_msg_box @endif" data-id="{{ $desk->user_id }}" data-userrole="{{ $desk->userrole }}" data-name="{{$desk->name}}">
                                <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                @lang('teacher.label_send_message')
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="@if(Auth::user()->id != $desk->user_id) shareedesk @endif" data-id="{{$desk->user_id}}">
                                <i class="fa fa-desktop" aria-hidden="true"></i>@lang('student.label_share_screen')
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        @endforeach
        @endif
    </div>
</div>