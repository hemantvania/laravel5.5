<footer>
    <ul class="clearfix">
        <li class="pull-left"><a href="#"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
            </a></li>
        @if (!Auth::guest())
            @if(Auth::user()->userrole == 2)
            <li id="class-date-time" class="pull-left copy-right hide">
                <span id="today-date">2017-08-31</span> | <span id="online_student">4/14</span> @lang('teacher.pupils_logged_in') |  @lang('teacher.lession_duration') <span id="timer">00:10:14</span>
            </li>
            <li id="progressbar" class="pull-left hide">
                <div class="progress  progress-striped active progress-custom">
                    <div class="progress-bar progress-bar-info"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"> <span class="sr-only">45% Complete</span> </div>
                </div>
            </li>
            @endif
        @endif
        <li class="pull-right"><a href="#"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
            </a></li>
        <li class="pull-right powered-by"><span>@lang('general.label_poweredby')</span><span>VIDRIO</span></li>
    </ul>
</footer>
@if(!empty(Auth::user()->id))
<div id="message_display" class="alert-message media">
    <div class="media-left"><i class="fa fa-check-circle" aria-hidden="true"></i>
    </div>
    <div class="media-body" id="status_msg">@lang('messages.your_data_saved_successfully')</div>
    <div class="media-right"><a href="javascript:void(0);" id="close-btn"><i class="material-icons">close</i></a></div>
</div>
<div id="error_message_display" class="alert-message media">
    <div class="media-left media-danger"><i class="material-icons">highlight_off</i></div>
    <div class="media-body" id="error_status_msg">@lang('adminuser.failure')</div>
    <div class="media-right"><a href="javascript:void(0);" class="close-btn-danger" id="close-btn-danger"><i class="material-icons">close</i></a></div>
</div>

<div id="incoming-message-container">

</div>
<div id="chatboxes">

</div>
<div id="StudentChatboxes">

</div>
<div class="incoming_message alert-message1 media">
    <div class="media-left"><i class="fa fa-commenting-o" aria-hidden="true"></i>
    </div>
    <div class="media-body">Desk ID
        <p>Beginning of the message...</p>
    </div>
    <a class="btn-reply-alert view_message">@lang('general.label_reply')</a>
</div>
@endif

@if(!empty(Auth::user()->id))
    <div class="modal fade" id="admin-change-password" style="display: none;">
        <div class="modal-dialog">

            <form action="{{ url('/admin/changepassword') }}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">@lang('general.changepassword')</h4>
                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}

                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" placeholder="@lang('general.current_password')" id="currentpassword" name="currentpassword" autocomplete="off" />
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" placeholder="@lang('general.new_password')" id="newpassword" name="newpassword" autocomplete="off" />
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" placeholder="@lang('general.confirm_new_password')" id="cofnewpassword" name="cofnewpassword" autocomplete="off" />
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left btn-vdesk-light" data-dismiss="modal">@lang('general.close')</button>
                        <button type="button" class="btn btn-vdesk" id="submit-change-pasword">@lang('general.save')</button>
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal" id="confirmDelete" data-id="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">@lang('general.delete')</h4>
                </div>
                <div class="modal-body">
                    <p>@lang('messages.you_are_about_to_delete')</p>
                    <p>@lang('messages.do_you_want_to_proceed')</p>
                </div>
                <div class="modal-footer">
                    <a href="#" id="btnYes" class="btn btn-default">@lang('general.yes')</a>
                    <a href="#" data-dismiss="modal" aria-hidden="true" class="btn btn-default">@lang('general.no')</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal" id="confirmClassComplete" data-id="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">@lang('general.delete')</h4>
                </div>
                <div class="modal-body">
                    <p>@lang('messages.you_are_about_to_delete')</p>
                    <p>@lang('messages.do_you_want_to_proceed')</p>
                </div>
                <div class="modal-footer">
                    <a href="#" id="btnYes" class="btn btn-default">@lang('general.yes')</a>
                    <a href="#" data-dismiss="modal" aria-hidden="true" class="btn btn-default">@lang('general.no')</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-static" id="class_paused" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"></div>
                <div class="modal-body">
                    <div class="pauseClass"><i class="material-icons">pause</i></div>
                    <h2>@lang('messages.classpaused')</h2>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    <div class="modal modal-static" id="class_end" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"></div>
                <div class="modal-body">
                    <div class="pauseClass"><i class="material-icons">stop</i></div>
                    <h2>@lang('messages.classended')</h2>
                    <a href="{{ url( App::getLocale().'/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-vdesk">@lang('student.okay')</a>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
@endif
