@foreach($students as $student)
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div id="student_{{$student->id}}" class="pulpetit-desk @if($student->is_active == '1') active @else inactive @endif">
        <div class="desk-head" data-user-id="{{$student->id}}">@lang('teacher.label_edesk')
                {{ $student->sequence }}
                {{ setStringLength($student->fullname,25) }}</div>
        <ul class="desk-action">
            <li><a href="javascript:void(0);" class="openchat" data-id="{{$student->id}}" data-sender="{{$student->fullname}}"><i class="fa fa-commenting-o" aria-hidden="true"></i>
                    @lang('teacher.label_send_message') </a></li>
            <li><a href="javascript:void(0);" class="manageedesk" data-id="{{$student->id}}" data-class-id="{{ $student->class_id}}" data-status="{{$student->status}}"><i class="fa fa-hand-paper-o" aria-hidden="true"></i>

                @if($student->status == 0)
                    <span> @lang('teacher.manage_edesk_off') </span>
                @else
                    <span> @lang('teacher.manage_edesk_on') </span>
                @endif
                </a></li>
            <li><a href="javascript:void(0);" class="shareedesk" data-id="{{$student->id}}"><i class="fa fa-desktop" aria-hidden="true"></i>
                    @lang('student.label_share_screen')</a></li>
            <li><a href="javascript:void(0);" class="takescreen" data-id="{{$student->id}}"><i class="fa fa-eye" aria-hidden="true"></i>
                    @lang('teacher.see_the_screen')</a></li>
        </ul>
    </div>
</div>
@endforeach
