

<!-- Message Modal Start -->
<div class="modal fade teacherMessage" tabindex="-1" role="dialog" aria-labelledby="teacherMessage" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">@lang('teacher.label_chat_message')</h4>
            </div>
            <div class="modal-body clearfix">
                <div class="chating-content clearfix">
                    <div class="id-section">
                        <ul class="online-list">
                            <li class="del-chat">
                                <a href="javascript:void(0);" class="del-chat1">
                                    <div class="id-number">0</div>
                                    <span class="chat-user-name">{{Auth()->user()->name}} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="msg-section">
                        <ul class="message_section">

                        </ul>
                        <div class="msg-input">
                            <textarea class="text_message" placeholder="Type Message" rows="1"></textarea>
                            <a href="#" class="reaction"><i class="material-icons">tag_faces</i></a>
                            <div class="msg-btn">

                                <a href="javascript:void(0);" class="chat-cancel-btn" data-dismiss="modal">@lang('general.close')</a>
                                <button type="button" class="send_message btn btn-secondary chat-theme-btn">@lang('teacher.label_chat_btn_send')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Message Modal End -->