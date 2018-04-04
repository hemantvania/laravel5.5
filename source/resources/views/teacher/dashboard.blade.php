@extends('layouts.vdesk')
@section("page-css")
    <link rel="stylesheet" href="{{ asset('plugins/datatables.net/css/dataTables.bootstrap.css') }}">
@endsection
@section('content')

    <section class="content-wrapper">
        <div class="container-fluid inner-contnet-wrapper">
            <div class="tab-wrapper">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="bs-example bs-example-tabs row main-tab-bg" role="tabpanel" data-example-id="togglable-tabs">
                           @include('error.message')
                            <ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist" style="text-align:right;">
                                @if ($errors->has('materialName') ||  $errors->has('link') || $errors->has('materialType') || $errors->has('materialType') || $errors->has('description') || $errors->has('uploadcontent'))

                                    <li role="presentation"> <a href="#aineisto" id="aineisto-tab" role="tab" data-toggle="tab" aria-controls="aineisto" aria-expanded="true"> <span class="text">@lang('teacher.label_material') </span> </a> </li>
                                @else
                                    <li role="presentation" class="active"> <a href="#aineisto" id="aineisto-tab" role="tab" data-toggle="tab" aria-controls="aineisto" aria-expanded="true"> <span class="text">@lang('teacher.label_material') </span> </a> </li>
                                @endif
                                <li role="presentation" class="next"> <a href="#pulpetit" role="tab" id="pulpetit-tab" data-toggle="tab" aria-controls="pulpetit"> <span class="text">@lang('teacher.label_edesk')</span> </a> </li>
                                <li role="presentation"> <a href="#communication" role="tab" id="communication-tab" data-toggle="tab" aria-controls="communication"> <span class="text">@lang('teacher.label_commution')</span> </a> </li>
                                <li role="presentation"> <a href="#studentsmanagement" role="tab" id="students-tab" data-toggle="tab" aria-controls="studentmanagement"> <span class="text">@lang('teacher.label_students')</span> </a> </li>
                                @if ($errors->has('materialName') || $errors->has('materialType') || $errors->has('materialType') || $errors->has('description') || $errors->has('uploadcontent'))
                                    <li role="presentation" class="active"> <a href="#contentsmanagement" role="tab" id="content-tab" data-toggle="tab" aria-controls="contentsmanagement"> <span class="text">@lang('teacher.content_label_title')</span> </a> </li>
                                @else
                                    <li role="presentation"> <a href="#contentsmanagement" role="tab" id="content-tab" data-toggle="tab" aria-controls="contentsmanagement"> <span class="text">@lang('teacher.content_label_title')</span> </a> </li>
                                @endif
                                    <li role="presentation"> <a href="#profile" role="tab" id="content-tab" data-toggle="tab" aria-controls="profile"> <span class="text">@lang('adminuser.profile')</span> </a> </li>
                                    <li role="presentation"> <a href="#notification" role="tab" id="notification-tab" data-toggle="tab" aria-controls="notification"> <span class="text">@lang('teacher.notification')</span> </a> </li>
                            </ul>
                        </div>
                    </div>
                    @include("comman.navigation")
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="myTabContent" class="tab-content">
                        @if ($errors->has('materialName') || $errors->has('link') || $errors->has('materialType') || $errors->has('materialType') || $errors->has('description') || $errors->has('uploadcontent'))
                             <div role="tabpanel" class="tab-pane fade " id="aineisto" aria-labelledby="aineisto-tab">
                        @else
                             <div role="tabpanel" class="tab-pane fade in active" id="aineisto" aria-labelledby="aineisto-tab">
                        @endif
                            @include("teacher.materialslist")
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="pulpetit" aria-labelledby="pulpetit-tab">
                            @include("teacher.edesklist")
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="communication" aria-labelledby="communication-tab">
                            @include("teacher.communication")
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="studentsmanagement" aria-labelledby="studentsmanagement">
                            @include("teacher.studentslist")
                        </div>
                        @if ($errors->has('materialName') || $errors->has('link') || $errors->has('materialType') || $errors->has('materialType') || $errors->has('description') || $errors->has('uploadcontent'))
                              <div role="tabpanel" class="tab-pane fade in active" id="contentsmanagement" aria-labelledby="contentsmanagement">
                        @else
                              <div role="tabpanel" class="tab-pane fade" id="contentsmanagement" aria-labelledby="contentsmanagement">
                        @endif
                            @include("teacher.contentlist")
                        </div>
                          <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile">
                              <div class="pulpetit-main">
                                  <div class="row">
                                        @include("layouts.user_profile")
                                  </div>
                              </div>
                          </div>

                          <div role="tabpanel" class="tab-pane fade" id="notification" aria-labelledby="notification-tab">
                              @include("teacher.notification")
                          </div>
                          @include("teacher.models")
                    </div>
                </div>
            </div>

                </div></div></div>
    </section>
    @include("teacher.chat")
    @include('teacher.screen-share-modal')
@endsection
@section('scripts')
    <script>
        /**
         * Initiate global variables
         */
        var globaltracker    = '';
        var globalinterval   = '';
        var notificationlist = '';
        var lbl_mchk         = '';
        var threadids        = [];
        var authid           = '{{Auth()->id()}}';

        var lbl_mname        = '@lang('teacher.label_material_name')';
        var lbl_mdesc        = '@lang('teacher.label_material_desc')';
        var lbl_mowner       = '@lang('teacher.label_owner')';
        var lbl_type         = '@lang('teacher.label_type')';
        var lbl_mfrom        = '@lang('teacher.isdownladable')';
        var lbl_mloaded      = '@lang('teacher.label_date')';

        var lbl_fname        = "@lang('teacher.label_s_firstname')";
        var lbl_lname        = "@lang('teacher.label_s_lastname')";
        var lbl_email        = "@lang('teacher.label_s_email')";
        var lbl_phone        = "@lang('teacher.label_s_phonenumber')";
        var lbl_addr         = "@lang('teacher.label_s_address')";

        var lbl_studentName  = "@lang('teacher.studentname')";
        var lbl_className    = "@lang('teacher.classname')";
        var lbl_date         = "@lang('teacher.completeddate')";
        var lbl_deloption    = "@lang('teacher.deleteoption')";

        var studentMessage   = '@lang('teacher.studentmaessage')';
        var edeskerrorMsg    = '@lang('teacher.select_class_show')';
        var mdownlodable     = '@lang('teacher.download')';
        var monline          = '@lang('teacher.online')';

        var shareScreenRequestTitle   = "@lang('teacher.incomingShareTitle')";
        var shareScreenRequestMessage = "@lang('teacher.incomingShareMessage')";
        var viewScreenRequestTitle    = "@lang('teacher.viewScreenTitle')";
        var viewScreenRequestMessage  = "@lang('teacher.viewScreenRequestMessage')";

        var managetouchon    = '@lang('teacher.manage_edesk_on')';
        var managetouchoff   = '@lang('teacher.manage_edesk_off')';

        var materilurl       = '{!! generateLangugeUrl(App::getLocale(),url('teacher/materiallist')) !!}';
        var studentsurl      = '{!! generateLangugeUrl(App::getLocale(),url('teacher/studentslist')) !!}';
        var notificationurl  = '{!! generateLangugeUrl(App::getLocale(),url('teacher/notificationslist')) !!}';
        var threadurl        = '{!! generateLangugeUrl(App::getLocale(),url('teacher/checkthread')) !!}';
        var messageurl       = '{!! generateLangugeUrl(App::getLocale(),url('teacher/sendmessage')) !!}';
        var classpauseurl    = '{!! generateLangugeUrl(App::getLocale(),url('teacher/pauseclass')) !!}';
        var classstopurl     = '{!! generateLangugeUrl(App::getLocale(),url('teacher/stopclass')) !!}';
        var resumeurl        = '{!! generateLangugeUrl(App::getLocale(),url('teacher/resumeclass')) !!}';
        var shareurl         = '{!! generateLangugeUrl(App::getLocale(),url('teacher/sharescreen')) !!}';
        var touchurl         = '{!! generateLangugeUrl(App::getLocale(),url('teacher/managetouch')) !!}';
        var materialdelurl   = '{!! generateLangugeUrl(App::getLocale(),url('teacher/deletematerial')) !!}';
        var btnplay          = jQuery('#play');
        var btnpause         = jQuery('.btn-pause');
        var btnstop          = jQuery('.btn-stop');
        var screenshareAuth  = '{{$screenAuth}}';
        @foreach($threads as $th)
            threadids.push({{$th['thread_id']}});
        @endforeach
        jQuery(function () {
            socket.on('vdesk-thread:'+authid+':App\\Events\\Thread', function(data){
                console.log('Here in Teacher'+data.threadid);
                threadids.push(data.threadid);
                $.each(threadids, function( index, value ) {
                    console.log('Array value'+ value);
                });
                generatesThreadIdsArray(threadids);
            });
        });

    </script>
    <script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/teachers/startclass.js') }}"></script>
    <script src="{{ asset('js/teachers/teachers.js') }}"></script>
    <script>
       jQuery(function () {

            //Fetching the Student Class Status
            socket.on('vdesk-channel:App\\Events\\StudentStatus', function(data){
                //   console.log('class-id---'+data.classid);
                if(data.classid){
                    notificationlist.ajax.reload();
                    showmessage(data.student_name + studentMessage);
                }
            });

            jQuery(function(){
                /* 25-10-17
                 * Open Upload materials tab on upload button click from material listing
                 * */
                jQuery('#btn_uploadMaterila').click(function(){
                    jQuery('#content-tab').trigger('click');
                });
            });
           generatesThreadIdsArray(threadids);
            /*$.each(threadids, function( index, value ) {
                socket.on('vdesk-chat:'+value+':App\\Events\\NewMessage', function (data) {
                    console.log(data.threadid)
                    console.log(value)
                    if (data.threadid == value) {

                        if(($("#chatbox_"+data.threadid).data('bs.modal') || {}).isShown){
                            var newmessage = '<li><h4>eDESK ID '+data.sendername+'</h4><p>'+data.message+'</p></li>'
                            jQuery("#chatbox_"+data.threadid).find(".message_section li:last-child").after(newmessage);
                            jQuery("#chatbox_"+data.threadid).find('.message_section').animate({
                                    scrollTop: jQuery("#chatbox_"+data.threadid).find('.message_section')[0].scrollHeight},
                                1000);
                        } else {
                            loadDynamicMessage(data)
                        }
                    }
                });
            });*/


            //Fetching the Student Logged Out Event
            socket.on('vdesk-userlogout:App\\Events\\UserLogout', function(data){
                    var loutid = 'student_'+data.userId
                    jQuery(".pulpetit-desk").each(function(index,value){
                        if(jQuery(this).attr('id') == loutid){
                            jQuery(this).addClass('inactive');
                            jQuery(this).removeClass('active');
                        }
                    });
            });
            //Fetching Socket User Logged in Events
            socket.on('vdesk-userlogin:App\\Events\\UserLogin', function(data){
                    var loginid = 'student_'+data.userId;
                    jQuery(".pulpetit-desk").each(function(index,value){
                        if(jQuery(this).attr('id') == loginid){
                            jQuery(this).addClass('active');
                            jQuery(this).removeClass('inactive');
                        }
                    });
            });

            //Incoming Share Screen Request Handler
            socket.on('vdesk-share:'+authid+':App\\Events\\StartScreenShare', function(data){
                var screenlink = data.link;

               /* jQuery('#incomingScreenShareModalLabel').text(shareScreenRequestTitle+data.requestedBy);
                jQuery('#incomingScreenShare .modal-body').text(shareScreenRequestMessage);*/
                jQuery('#incomingScreenShareModalLabel').text(data.requestedBy+viewScreenRequestTitle);
                jQuery('#incomingScreenShare .modal-body').text(viewScreenRequestMessage);

                jQuery("#btnviewscreen").attr('data-url',screenlink);
                jQuery("#incomingScreenShare").modal('show');
            });
        });
    </script>
@endsection