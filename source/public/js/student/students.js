jQuery(function () {

    /**
     * Setting up the ajax with laravel token
     */
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**
     *  Start Class Event Hanlder
     */
    socket.on('vdesk-channel:App\\Events\\StartClass', function (data) {
        if (userClass) {
            if (data.classid === userClass) {
                showloader();
                jQuery.ajax({
                    url: getClassUrl,
                    type: 'POST',
                    data: {
                        'classid': userClass
                    },
                    success: function (data) {
                        showloader();
                        jQuery("#aineisto").html('');
                        jQuery("#aineisto").html(data);
                    },
                    error: function (data) {
                        showloader();
                    }
                });
                jQuery('#class_paused').modal('hide');
            }
        }
    });

    /**
     * Chat Message Application
     */
   /* $.each(threadids, function (index, value) {
        socket.on('vdesk-chat:' + value + ':App\\Events\\NewMessage', function (data) {
            if (data.threadid == value) {
                if(($("#chatbox_"+data.threadid).data('bs.modal') || {}).isShown){
                    var newmessage = '<li><h4>' +labeleDesl + " " + data.sendername + '</h4><p>' + data.message + '</p></li>'
                    jQuery(".message_section li:last-child").after(newmessage);
                    jQuery("#chatbox_"+data.threadid).find('.message_section').animate({
                            scrollTop: jQuery("#chatbox_"+data.threadid).find('.message_section')[0].scrollHeight},
                        1000);
                } else {
                    if (userid != data.senderid) {
                        loadDynamicMessage(data)
                    }
                }
            }
        });
    });*/
    generatesThreadIdsArray(threadids);

    /**
     * I am done with this class event handler
     */
    jQuery('#aineisto').on('click', '#imDone', function () {
        var classID = jQuery(this).data('class-id');
        if (classID) {
            showloader();
            jQuery.ajax({
                url: doneClassUrl,
                type: 'POST',
                data: {
                    'classid': classID
                },
                success: function (data) {
                    showloader();
                    if (data.status == true) {
                        jQuery("#logout-form").submit();
                        //jQuery('#imDone').attr('disabled', true).addClass('disabled')
                        //showmessage(data.message);
                    } else {
                        jQuery('#imDone').attr('disabled', false).removeClass('disabled');
                        showmessage(data.message);
                    }
                    //location.reload();
                  //  jQuery("#logout-form").submit();
                },
                error: function (data) {
                    showloader();
                    if (data.status === false) {
                        showmessage(data.message);
                    }
                }
            });

        }
        else {
            showloader();
        }

    });

    /**
     * Open Message Box Click Event Handler
     */
    jQuery('.open_msg_box').on('click', function () {

            var btn = jQuery(this);
            var toUserId = btn.attr('data-id');
            var toUserRole = btn.attr('data-userrole');
            var toUserName = btn.attr('data-name');

            if (toUserId) {
                showloader();
                jQuery.ajax({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: studentOpenMessageBoxUrl,
                    type: 'POST',
                    data: {
                        'to_user_id': toUserId,
                        'to_user_role': toUserRole,
                        'to_user_name': toUserName,
                    },
                    success: function (data) {
                        if (data) {
                            showloader();
                            if(data.threadid != ''){
                                loadStudentChatBox(data, data.threadid, toUserId, data.senderName, toUserRole, toUserName)
                            }
                        }
                    },
                    error: function (data) {
                        if (data.status === false) {
                            showmessage(data.message);
                        }
                    }
                });
            }

    });


    /**
     * Send message Event Handler
     */
    jQuery(document).on('click', '.btn_send', function () {

            var chatObj = jQuery(this);
            var threadId = chatObj.attr('thread-id');
            var msg = jQuery('#msg_' + threadId).val();
            var toUserId = chatObj.attr('data-id');
            var toUserRole = chatObj.attr('sender-role');
            var toUserName = chatObj.attr('to_user_name');

            if (!msg) {
                showerrormessage(errorWriteMsg);
                return false;
            }
            if (!toUserId) {
                showerrormessage(errorFailureMsg);
                return false;
            }
            showloader();

            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: studentMsgSendUrl,
                type: 'POST',
                data: {
                    'to_user_id': toUserId,
                    'to_user_role': toUserRole,
                    'to_user_name': toUserName,
                    'message': msg,
                    'thread_id': threadId,
                },
                success: function (data) {

                    if (data) {
                        jQuery('#msg_' + threadId).val('');
                    }
                },
                error: function (data) {
                    if (data.status === false) {
                        showmessage(data.message);
                    }
                }
            });
            showloader();

    })

    /**
     * View Incoming Message Event Handler
     */
    jQuery(document).on('click', '.view_message', function () {

            var threadId = jQuery(this).parent().attr('thread-id');
            var senderId = jQuery(this).parent().attr('sender-id');
            var sendername = jQuery(this).parent().attr('sendername');
            var senderrole = jQuery(this).parent().attr('sender-role');

            if (threadId) {
                showloader();
                jQuery.ajax({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: studentOpenMessageBoxUrl,
                    type: 'POST',
                    data: {
                        'to_user_id': senderId,
                        'to_user_role': senderrole,
                        'to_user_name': sendername,
                        'thread_id': threadId,
                    },
                    success: function (data) {
                        if (data) {
                            showloader();
                            if(data.threadid != ''){
                                loadStudentChatBox(data, data.threadid, senderId, data.sendername, senderrole, sendername)
                            } else {
                                showmessage(data.message);
                            }
                        }
                    },
                    error: function (data) {
                        if (data.status === false) {
                            showmessage(data.message);
                        }
                    }
                });
            }
            else {
                showerrormessage(errorFailureMsg);
                return false;
            }
            jQuery(this).parent().toggleClass('active');

    });

    /**
     * Enter Key press event handler
     */

    jQuery(document).keypress(function(e) {
        if(e.which == 13) {
           if(jQuery('#StudentChatboxes').find('.studentChatBox').length != 0)
           {
               var boxID = jQuery('#StudentChatboxes').find('.studentChatBox').attr('id');
               var messageIs = jQuery('#'+boxID).find('.msg').val();
               if(messageIs != "")
               {
                   jQuery('#StudentChatboxes').find('.btn_send').trigger('click');
                   e.preventDefault();
               }
            }
        }
    });

    /**
     * Add clicked materil to users material statistic table
     */
    jQuery('.material-listing').on('click',function () {
        var materal = jQuery(this);
        var materialId = materal.attr('material-id');
        var classId = materal.attr('class-id');

        if (materialId && classId)
        {
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: materialViewedUrl,
                type: 'POST',
                data: {
                    'class_id': classId,
                    'material_id': materialId,
                },
                success: function (data) {
                    if (data) {
                        console.log(data);
                    }
                },
                error: function (data) {
                    if (data.status === false) {
                        showmessage(data.message);
                    }
                }
            });
        }
        else
        {
            console.log('Error: no class or material id found');
        }
    });



    /**
     * Own Screen Share Individual click Event Handler
     */
    jQuery(document).on("click",".shareedesk",function(e){

            showloader();
            var shareid = jQuery(this).attr('data-id');
            /**
             * Ajax Call For Thread
             */
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: shareurl,
                type: 'POST',
                data: {
                    'shareids': shareid,
                    'viwer':'true',
                },
                success: function (data) {
                    showloader();
                    if(data.status === false){
                        showerrormessage(data.message);
                    } else {
                        var sharingWindow =  window.open(data.presenterLink, '_blank');
                        closeWindow(sharingWindow);
                    }
                },
                error: function (data) {
                    showloader();
                    if (data.status === false) {
                        showerrormessage(data.message);
                    }
                }
            });

    });



})

/**
 * Load the chat box based on the dynamic id
 * @param data
 * @param threadid
 * @param senderid
 * @param sendername
 * @param touserrole
 * @param toUserName
 */
function loadStudentChatBox(data,threadid,senderid,sendername,touserrole,toUserName){

        var chatBoxid = 'chatbox_' + threadid;
        var newChatbox = '';
        if (jQuery("#" + chatBoxid).length == 0) {
            newChatbox = jQuery(".studentChatBox").clone().prop('id', chatBoxid);
            jQuery("#StudentChatboxes").append(newChatbox);
        }
        var userRole = (touserrole !== null) ? touserrole : "";
        var objChatbox = jQuery("#" + chatBoxid);

        objChatbox.find('.btn_send').attr({
            'data-id': senderid,
            'thread-id': threadid,
            'sender-role': userRole,
            'to_user_name': toUserName
        });
        objChatbox.find('.msg').attr('id', 'msg_' + threadid);
        objChatbox.find(".message_section").html(data.message);
        objChatbox.find(".modal-title").text(data.label);

        objChatbox.modal('show');

        jQuery("#" + chatBoxid).on('shown.bs.modal', function () {
            jQuery("#" + chatBoxid).find('.message_section').animate({
                    scrollTop: jQuery("#" + chatBoxid).find('.message_section')[0].scrollHeight
                },
                1000);
        })

        jQuery("#" + chatBoxid).on('hidden.bs.modal', function () {
            $(this).data('bs.modal', null);
            $(this).remove();
        });
}

/**
 * Shreen Share Event Handler
 */
jQuery(document).on('click',"#sharescreen",function(){

    showloader();
    var shareids = '';
    jQuery('#share_screen_students input[type="checkbox"]').each(function (index, value) {
        if (jQuery(this).is(':checked')) {
            if (shareids === '') {
                shareids = jQuery(value).val();
            } else {
                shareids = shareids + "," + jQuery(value).val();
            }
        }
    });
    //   console.log(shareids);

    /**
     * Ajax Call For Thread
     */
    jQuery.ajax({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        url: shareurl,
        type: 'POST',
        data: {
            'shareids': shareids,
            'viwer':'true',
        },
        success: function (data) {
            showloader();
            if(data.status === false){
                showerrormessage(data.message);
            } else {
                if (data.presenterLink != '') {
                    var sharingWindow = window.open(data.presenterLink, '_blank');
                    if(!data.isViwer) {
                        closeWindow(sharingWindow);
                    }
                }
            }
        },
        error: function (data) {
            showloader();
            if (data.status === false) {
                showerrormessage(data.message);
            }
        }
    });

});