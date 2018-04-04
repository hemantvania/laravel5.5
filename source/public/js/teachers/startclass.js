jQuery(function () {
	var Clock 	  = '';
	var totaltime = 0;
	var iPerc  	  = 0;
       StartClasses = {  
            Start : function (totaltime){
				Clock = {
					totalSeconds  : totaltime,
					totalTime     : totaltime,
					start         : function () {
                                        var self      = this;
                                        this.interval = setInterval(function () {
                                            self.totalSeconds -= 1;
                                            if(self.totalSeconds >= 0) {
                                                var iHours   = Math.floor(self.totalSeconds / 3600);
                                                var iMin 	 = Math.floor(self.totalSeconds / 60 % 60);
                                                var iSec 	 = parseInt(self.totalSeconds % 60);
                                                Clock.setTimerDisplay(iHours, iMin, iSec);
                                                iPerc = iPerc + ( 100 / self.totalTime );
                                                jQuery('.progress-bar').css('width', iPerc + '%');
                                                if (iPerc >= 100) {
                                                    iPerc = 0;
                                                    StartClasses.Clearbar();
                                                }
                                            } else {

                                            }
                                        }, 1000);
                                    },

					pause  : function () {
						clearInterval(this.interval);
						delete this.interval;
					},

					resume  : function () {
						if (!this.interval) this.start();
					},

					stop   : function(){
						self.totalSeconds = 0;
						clearInterval(this.interval);
						delete this.interval;
						Clock.setTimerDisplay('0','0','0');
					},

					setTimerDisplay : function(iHours, iMin, iSec){
						var formated = StartClasses.formatClockTime(iHours, iMin, iSec);
                        jQuery('#timer').html(formated);
					}
					
				};

				Clock.start();
			},
			Clearbar : function(){
				jQuery('.progress-bar').css('width', 0 + '%');
				iPerc = 0;	
			},
            formatClockTime : function(h, m, s){
               if (h < 10) h = "0" + h;
               if (m < 10) m = "0" + m;
               if (s < 10) s = "0" + s;
               return h + ":" + m + ":" + s;
		    },
            setTodayDate : function (){
                var d       = new Date();
                var month   = d.getMonth() + 1;
                var day     = d.getDate();
                var output  = d.getFullYear() + '/' +
                    (('' + month).length < 2 ? '0' : '') + month + '/' +
                    (('' + day).length < 2 ? '0' : '') + day;
                jQuery("#today-date").html('');
                jQuery("#today-date").html(output);
            }
		}

		if(iPerc > 0) {
            var exitmessage = 'Please dont go!'; //custome message
            DisplayExit = function() {
                return exitmessage;
            };
            window.onbeforeunload = DisplayExit;
        }
        /**
         * Handler the ctrl +F5 events when class is started
         */
        jQuery("body").keydown(function(e){
             if (e.keyCode == 116 && e.ctrlKey) {
                 if(iPerc > 0 ) {
                     e.preventDefault();
                 }
             }
        });
        /**
         * Handler the ctrl +F5 events when class is started
         */
        jQuery("body").keypress(function(e){
            if (e.keyCode == 116) {
                if(iPerc > 0 ) {
                    e.preventDefault();
                }
            }
        });

		jQuery('.btn-pause').click(function(){
            showloader();
		    jQuery(this).toggleClass('active');
            btnplay.removeClass('active');
            Clock.pause();
            var classid = jQuery('input[name=classoptions]:checked').val();
            /**
             * Ajax Call for Pause Class
             */
             jQuery.ajax({
                 headers : {
                     'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                 },
                 url     : classpauseurl,
                 type    : 'POST',
                 data    : {
                     'classid': classid
                 },
                 success : function (data) {
                     showloader();

                 },
                 error   : function (data) {
                     showloader();
                     if (data.status === false) {
                         showerrormessage(data.message);
                     }
                 }
             });
         });

     jQuery('.btn-stop').click(function(){
         showloader();
         StartClasses.Clearbar();
         Clock.stop();
         totaltime = 0;
         btnplay.removeClass('active');
         btnpause.removeClass('active');
         var classid = jQuery('input[name=classoptions]:checked').val();
         /**
          * Ajax Call To Fire Stop Class
          */
          jQuery.ajax({
              headers   : {
                  'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              },
              url      : classstopurl,
              type     : 'POST',
              data     : {
                  'classid': classid
              },
              success  : function (data) {
              },
              error    : function (data) {
                  if (data.status === false) {
                      showerrormessage(data.message);
                  }
              }
          });

          jQuery("#class-date-time").addClass('hide');
          jQuery("#progressbar").addClass('hide');

          setTimeout(function () {
              showloader();
          }, 1000);
     });

     /**
      * Click event for play button to start class
      */
        btnplay.click(function () {
            showloader();
            setTimeout(function () {
                showloader();
            }, 1000);
            var classroll = true;
            if (btnpause.hasClass('active')) {
                classroll = false;
            }
            if (btnstop.hasClass('active')) {
                classroll = false;
            }
            if (classroll === true) {
                jQuery('#switch_class').modal().show();
            } else {
                Clock.resume();
                btnstop.removeClass('active');
                btnpause.removeClass('active');
                jQuery(this).addClass('active');
                var opClassId = jQuery('input[name=classoptions]:checked').val();
                jQuery.ajax({
                    headers  : {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url      : resumeurl,
                    type     : 'POST',
                    data     : {
                        'classid': opClassId,
                    },

                    success  : function (data) {
                    },

                    error   : function (data) {
                    }
                });
            }
        });
    /**
     * Click Event Handler of start button
     */
    jQuery("#btnstart").click(function () {
        showloader();
        var opClassId       = jQuery('input[name=classoptions]:checked').val();
        TeacherStarteClass  = opClassId;
        var opTime          = jQuery('input[name=classoptions]:checked').attr('data-time');
        var starturl        = jQuery('#start_class').attr('action');
        var onlinestudent   = jQuery('#start_class').attr('data-url');
        checkloggedInStudent(opClassId, onlinestudent)
        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            url: starturl,
            type: 'POST',
            data: {
                'classid': opClassId, 'time': opTime
            },
            success: function (data) {
                showloader();
                jQuery('#switch_class').modal('hide');
                if (data.status == true) {
                    jQuery("#online_students").html('');
                    jQuery.each(data.onlinestudents, function (index, value) {
                        jQuery("#online_students").append('<li><label class="radio-btn"><input name="chat-student-list" value="' + value.id + '" data-title="' + value.fullname + '" type="checkbox"/>' + value.fullname + '</label></li>')
                        // Appending Online Class user to share screen dropdown
                        if (jQuery("#share_screen_students").length > 0) {
                            jQuery("#share_screen_students").append('<li><label class="radio-btn"><input name="share-screen-student-list" value="' + value.id + '" data-title="' + value.fullname + '" type="checkbox"/>' + value.fullname + '</label></li>');
                        }
                    });
                    showmessage(data.message);
                    StartClasses.Clearbar();
                    StartClasses.Start(opTime * 60 );
                    jQuery('.btn-play').addClass('active');
                    jQuery("#class-date-time").removeClass('hide');
                    jQuery("#progressbar").removeClass('hide');
                    StartClasses.setTodayDate()
                } else {
                    showerrormessage(data.message);
                }
                jQuery(".loadmoreimg").hide();
            },
            error: function (data) {
                showloader();
                jQuery('#switch_class').modal('hide');
                if (data.status === false) {
                    showerrormessage(data.message);
                }
            }
        });
    });
});
