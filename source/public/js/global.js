/**
 * display an alert message
 *
 */
function showmessage(message){
    jQuery('#status_msg').html(message)
    jQuery('#message_display').toggleClass('active');
    setTimeout(function(){
        jQuery('#message_display').toggleClass('active');
    }, 3000);
}
/**
 * display an error alert message
 *
 */
function showerrormessage(message){
    jQuery('#error_status_msg').html(message)
    jQuery('#error_message_display').toggleClass('active');
    setTimeout(function(){
        jQuery('#error_message_display').toggleClass('active');
    }, 3000);
}
/**
 * display an loader on body tag
 *
 */
function showloader(){
    jQuery("body").toggleClass('loading-mask');
}

/**
 * Show Ajax Form submit validation messages
 *
 */
function showFormVadlidationMessage(ids,value){
    jQuery('#'+ids).parent().parent().addClass('has-error');
    jQuery('#'+ids).parent().find('.help-block').remove();
    jQuery('#'+ids).after('<span class="help-block"><strong>'+value+'</strong></span>');
}

jQuery(function() {

    /**
     * Toggle an for dynamic message display
     *
     */
    setTimeout(function(){
        jQuery("#dynamic_display").toggleClass('active');
    }, 3000);

    /**
     * Teacher dashboard language switcher
     *
     */
    jQuery('#language_switcher').change(function (e) {
        var url = jQuery(this).find('option:selected').attr('data-url');
        var redirectUrl = url
        window.location.href = redirectUrl;
    });

    /**
     * On Load of the documents added selected langege
     *
     */

    setTimeout(function(){
        var selectclass = jQuery('#language_switcher option:selected').attr('class');
        jQuery(".flag-options .bootstrap-select .btn").addClass(selectclass);
    }, 100);

    /**
     * Change password submit ajax handler
     *
     */
    jQuery("#submit-change-pasword").on('click', function(e) {

        e.preventDefault();

        jQuery( "#admin-change-password .modal-header .alert-danger").remove();
        jQuery( "#admin-change-password .modal-header .alert-success").remove();

        var currentpassword = jQuery('#currentpassword').val();
        var newpassword = jQuery('#newpassword').val();
        var cofnewpassword = jQuery('#cofnewpassword').val();
        var token = jQuery('input:hidden[name=_token]').val();

        if( currentpassword != '' && newpassword != '' && cofnewpassword != '') {
            if(newpassword !== cofnewpassword){
                jQuery( "#admin-change-password .modal-header" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>New password does not match.</div>' );
            } else  {
                jQuery.ajax({
                    //headers : {'X-CSRF-TOKEN' : token},
                    type: "POST",
                    url: '/changepassword',
                    beforeSend: function (xhr) {
                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {'curPassword': currentpassword, 'newPassword': newpassword, 'confNewPassword': cofnewpassword},
                    success: function (data) {
                        if ( data.status == true ) {
                            jQuery("#admin-change-password .modal-header").prepend('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message + '</div>');
                            jQuery('#currentpassword').val('');
                            jQuery('#newpassword').val('');
                            jQuery('#cofnewpassword').val('');

                        } else {
                            if(data.newPassword !='') {
                                jQuery( "#admin-change-password .modal-header" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.newPassword +'</div>' );
                            } else if (data.confNewPassword !='') {
                                jQuery( "#admin-change-password .modal-header" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.confNewPassword +'</div>' );
                            } else {
                                jQuery( "#admin-change-password .modal-header" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message +'</div>' );
                            }

                        }

                    },
                    error: function (data) {
                        var dataerror = data.responseJSON;

                        if(dataerror.newPassword !='') {
                            jQuery( "#admin-change-password .modal-header" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + dataerror.newPassword +'</div>' );
                        } else if (dataerror.confNewPassword !='') {
                            jQuery( "#admin-change-password .modal-header" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + dataerror.confNewPassword +'</div>' );
                        } else {
                            jQuery( "#admin-change-password .modal-header" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Some error occured.</div>' );
                        }

                    }
                });
            }
        } else {
            jQuery( "#admin-change-password .modal-header" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Fields are required.</div>' );
            jQuery( "#admin-change-password .modal-body .form-group" ).addClass('has-error');
        }
    });

    /**
     * Close Success Message handler
     *
     */
    jQuery("#close-btn").click(function(){
        jQuery("#message_display").removeClass('active');
    });

    /**
     * Close Error Message handler
     *
     */
    jQuery("#close-btn-danger").click(function(){
        jQuery("#error_message_display").removeClass('active');
    });

    jQuery(".close-btn-danger").click(function(){
        jQuery(this).parent().parent().removeClass('active');
        //jQuery("#error_message_display").removeClass('active');
    });

    /**
     * Close Dynamic Message handler
     *
     */
    jQuery("#close-btn-dynamic").click(function(){
        jQuery("#dynamic_display").removeClass('active');
    });

});

/**
 * display dynamic message.
 * @param data
 */
function loadDynamicMessage(data){
    var messageid   = 'message_'+data.threadid;
    var newmessage  = data.sendername+'<p>'+data.message+'</p>';
    var newIncoming = '';

    if(jQuery("#"+messageid).length == 0) {
        var newIncoming = jQuery(".incoming_message").clone().prop('id', messageid);
        jQuery("#incoming-message-container").append(newIncoming);
    }

    jQuery("#"+messageid).attr('thread-id',data.threadid);
    jQuery("#"+messageid).attr('sender-id',data.senderid);
    jQuery("#"+messageid).attr('sendername',data.sendername);
    jQuery("#"+messageid).attr('sender-role',data.senderrole);
    jQuery("#"+messageid).find('.media-body').html(newmessage);
    jQuery("#"+messageid).addClass('active');
}

/**
 * Loading dyanmic Chat Boxex
 * @param data
 */
function loadChatBox(data,treadid,senderid,sendername, single){
    
    var chatBoxid = 'chatbox_'+treadid;
    var newChatbox = '';
    if(jQuery("#"+chatBoxid).length == 0) {
        newChatbox = jQuery(".teacherMessage").clone().prop('id', chatBoxid);
        jQuery("#chatboxes").append(newChatbox);
    }

    var objChatbox = jQuery("#"+chatBoxid);
    objChatbox.find('.online-list li:not(:first)').remove();
    var totalStudents = objChatbox.find('.online-list li').length;

    if(single === true){
        objChatbox.find(".online-list").append('<li class="del-chat"><a href="javascript:void(0);" class="del-chat1"><div class="id-number">'+totalStudents+'</div><span class="chat-user-name">eDESK '+totalStudents +' '+sendername +'</span><button type="button" class="close-list-btn"><i class="material-icons">close</i></button></a></li>')
    } else {
        var innnerids = '';
        jQuery('#online_students input[type="checkbox"]').each(function(index,value){
            if(jQuery(this).is(':checked')){
                if(innnerids === ''){
                    innnerids = jQuery(value).val();
                } else {
                    innnerids = innnerids +","+ jQuery(value).val();
                }
                totalStudents = totalStudents + index;
                objChatbox.find(".online-list").append('<li class="del-chat"><a href="javascript:void(0);" class="del-chat1"><div class="id-number">'+totalStudents+'</div><span class="chat-user-name">eDESK '+totalStudents +' '+jQuery(this).attr('data-title') +'</span><button type="button" class="close-list-btn"><i class="material-icons">close</i></button></a></li>')
            }
        });
        senderid = innnerids;
    }

    objChatbox.attr('students-ids',senderid);
    objChatbox.find(".message_section").html(data.message);
    objChatbox.modal('show');

    jQuery("#"+chatBoxid).on('shown.bs.modal', function () {
        jQuery("#"+chatBoxid).find('.message_section').animate({
                scrollTop: jQuery("#"+chatBoxid).find('.message_section')[0].scrollHeight},
            1000);
    })
    ClearCheckBox();

    jQuery("#"+chatBoxid).on('hidden.bs.modal', function () {
        $(this).data('bs.modal', null);
        $(this).remove();
    });
}

/**
 * Clear the checkboxes with  online students
 * @constructor
 */
function ClearCheckBox(){
    jQuery('#online_students input[type="checkbox"]').attr('checked',false);
}

/**
 *
 */
function generatesThreadIdsArray(threadids){
    $.each(threadids, function( index, value ) {
        socket.on('vdesk-chat:'+value+':App\\Events\\NewMessage', function (data) {
            console.log(data.threadid)
            console.log(value)
            if (data.threadid == value) {

                if(($("#chatbox_"+data.threadid).data('bs.modal') || {}).isShown){

                    var newmessage = '<li><h4>eDESK ID '+data.sendername+'</h4><span class="chat_time">'+ data.created_at+'</span><p>'+data.message+'</p></li>'
                    jQuery("#chatbox_"+data.threadid).find(".message_section li:last-child").after(newmessage);
                    jQuery("#chatbox_"+data.threadid).find('.message_section').animate({
                            scrollTop: jQuery("#chatbox_"+data.threadid).find('.message_section')[0].scrollHeight},
                        1000);
                } else {
                    loadDynamicMessage(data)
                }
            }
        });
    });
}

