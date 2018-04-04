<div class="modal fade studentChatBox" tabindex="-1" role="dialog" aria-labelledby="teacherMessage" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body media">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <div class="media-left"><i class="fa fa-commenting-o" aria-hidden="true"></i>
                </div>
                <div class="msg-section media-body msg-section">
                    <h4 class="modal-title"></h4>
                    <div id="view_messages"></div>
                    <ul class="message_section">

                    </ul>
                    <div class="msg-input">
                        <textarea name="message" class="msg" placeholder="@lang('general.type_message')" rows="1"></textarea>
                        <a href="#" class="reaction"><i class="material-icons">tag_faces</i></a>
                        <div class="msg-btn">
                            <a id="btn_cancel" href="javascript:void(0)" class="chat-cancel-btn" data-dismiss="modal" aria-label="Close">@lang('general.close')</a>
                            <button type="submit" class="btn_send btn btn-secondary chat-theme-btn">@lang('teacher.label_chat_btn_send')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
