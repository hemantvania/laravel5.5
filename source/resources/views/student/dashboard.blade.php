@extends('layouts.vdesk')

@section('content')
    <section class="content-wrapper">
        <div class="container-fluid inner-contnet-wrapper">
            <div class="tab-wrapper">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-6 col-xs-12">
                        <div class="bs-example bs-example-tabs row main-tab-bg" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist" style="text-align:right;">
                                <li role="presentation" class="active"> <a href="#aineisto" id="aineisto-tab" role="tab" data-toggle="tab" aria-controls="aineisto" aria-expanded="true"> <span class="text">@lang('student.label_material')</span> </a> </li>
                                <li role="presentation" class="next"> <a href="#pulpetit" role="tab" id="pulpetit-tab" data-toggle="tab" aria-controls="pulpetit"> <span class="text">@lang('student.label_edesk')</span> </a> </li>
                                <li role="presentation" class=""> <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile"> <span class="text">@lang('adminuser.profile')</span> </a> </li>
                            </ul>
                        </div>
                    </div>
                    @include("comman.navigation")
                </div>
            </div>
            @include('error.message')

            <div class="row">
                <div class="">
                    <div class="col-sm-12">
                        <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="aineisto" aria-labelledby="aineisto-tab">
                                   @include('student.materialstlist_tab')
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="pulpetit" aria-labelledby="pulpetit-tab">
                                    @include('student.edeskgrid_tab')
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
                                <div class="profile-tab">
                                 @include('layouts.user_profile')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('student.modal-message-box')
    @include('student.screen-share-modal')
    @include('student.screen-lock-box')
@endsection

@section('scripts')
    <script type="text/javascript">

        var labelTeacher              = "@lang('general.label_teacher')";
        var labeleDesl                = "@lang('teacher.label_edesk')";
        var errorWriteMsg             = "@lang('messages.error_write_msg')";
        var errorFailureMsg           = "@lang('messages.error_failure')";
        var shareScreenRequestTitle   = "@lang('student.incomingShareTitle')";
        var shareScreenRequestMessage = "@lang('student.incomingShareMessage')";
        var viewScreenRequestTitle    = "@lang('student.viewScreenTitle')";
        var viewScreenRequestMessage  = "@lang('student.viewScreenRequestMessage')";

        var studentOpenMessageBoxUrl  = '{!! generateLangugeUrl(App::getLocale(),url('openmessagebox')) !!}';
        var studentMsgSendUrl         = '{!! generateLangugeUrl(App::getLocale(),url('sendmessage')) !!}';
        var studentViewMsgUrl         = '{!! generateLangugeUrl(App::getLocale(),url('viewmessage')) !!}';
        var materialViewedUrl         = '{!! generateLangugeUrl(App::getLocale(),url('viewmaterial')) !!}';
        var getClassUrl               = '{!! generateLangugeUrl(App::getLocale(),url('classmaterials')) !!}';
        var doneClassUrl              = '{!! generateLangugeUrl(App::getLocale(),url('classcompleted')) !!}';
        var shareurl                  = '{!! generateLangugeUrl(App::getLocale(),url('sharescreen')) !!}';
        var userid                    = "{{auth()->user()->id}}";
        var userClass                 = 0;
        var threadids                 = [];
        var touchstatus               = "{{$touchstatus}}"
        @if(!empty($userClass))
            userClass = "{{$userClass->class_id}}";
            @foreach($threads as $th)
                threadids.push({{$th['thread_id']}});
            @endforeach

            socket.on('vdesk-thread:'+userid+':App\\Events\\Thread', function(data){
                console.log('Here Student '+data.threadid);
                threadids.push(data.threadid);
                generatesThreadIdsArray(threadids);
            });

        @endif

    </script>
    <script src="{{ asset('js/student/students.js') }}"></script>
    <script>
        jQuery(function () {

            /**
             * Check for the class if its locked by teacher for logged in students
             */
            if(touchstatus == 0) {
                jQuery('#class_locked').modal('hide');
            } else {
                jQuery('#class_locked').modal('show');
            }
            /**
             * Pause Class Event Handler
             */
            socket.on('vdesk-class:'+userClass+':App\\Events\\PauseClass', function(data){
                if(userClass) {
                    if (data.classid == userClass) {
                        jQuery('#class_paused').modal('show');
                    }
                }
            });


            /**
             * Lock Class Event Handler
             */
            socket.on('vdesk-student-lock:'+userid+':App\\Events\\StudentLock', function(data){
                console.log('Here');
                if(userid) {
                    console.log('++Hi');
                    if (data.userid == userid) {
                        console.log('++Heloo++');
                        if(data.classid == userClass)
                        {
                            console.log('++++');
                            if(data.status == 0) {
                                jQuery('#class_locked').modal('hide');
                            }  else {
                                jQuery('#class_locked').modal('show');
                            }
                        }
                    }
                }
            });


            /**
             * Stop Class Event Handler
             */
            socket.on('vdesk-class:'+userClass+':App\\Events\\StopClass', function(data){
                if(userClass) {
                    if (data.classid == userClass) {
                        jQuery('#class_end').modal('show');
                        setTimeout(function(){
                            jQuery("#logout-form").submit();
                        }, 3000);
                    }
                }
            });

            //Fetching the Student Logged Out Event
            socket.on('vdesk-userlogout:App\\Events\\UserLogout', function(data){
                var logoutid = 'student_'+data.userId
                jQuery(".pulpetit-desk").each(function(index,value){
                    if(jQuery(this).attr('id') == logoutid){
                        jQuery(this).addClass('inactive');
                        jQuery(this).removeClass('active');
                    }
                });
            });
            //Fetching Socket User Logged in Events
            socket.on('vdesk-userlogin:App\\Events\\UserLogin', function(data){
                var logedinid = 'student_'+data.userId;
                jQuery(".pulpetit-desk").each(function(index,value){
                    if(jQuery(this).attr('id') == logedinid){
                        jQuery(this).addClass('active');
                        jQuery(this).removeClass('inactive');
                    }
                });
            });

            //Incoming Share Screen Request Handler
            socket.on('vdesk-share:'+userid+':App\\Events\\StartScreenShare', function(data){

                var screenlink = data.link;
                var  viewer = data.isViwer
                var userRole = data.userRole;

                 if(viewer == 'true')
                 {
                    console.log('true');
                     jQuery('#incomingScreenShareModalLabel').text(data.requestedBy+viewScreenRequestTitle);
                     jQuery('#incomingScreenShare .modal-body').text(viewScreenRequestMessage);
                 } else {
                     console.log('false');
                     jQuery('#incomingScreenShareModalLabel').text(shareScreenRequestTitle);
                     jQuery('#incomingScreenShare .modal-body').text(shareScreenRequestMessage+data.requestedBy);
                 }
                jQuery("#btnviewscreen").attr('data-url', screenlink);
                jQuery("#incomingScreenShare").modal('show');

                if(userRole == 3 )
                {
                    jQuery("#incomingScreenShare #share_footer").show();
                }
                else
                {
                    jQuery("#incomingScreenShare #share_footer").hide();
                }

                if(userRole == 2 ) {
                    setTimeout(function () {
                        shareScreen(screenlink, viewer);
                    }, 5000);
                }
            });

        });

    </script>
@endsection