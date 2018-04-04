jQuery(function () {



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
                            url: '/admin/changepassword',
                             beforeSend: function (xhr) {
                                 if (token) {
                                     return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                                 }
                             },
                            data: {'curPassword': currentpassword, 'newPassword': newpassword, 'confNewPassword': cofnewpassword},
                            success: function (data) {
                                if ( data.status == true ) {
                                    jQuery("#admin-change-password .modal-header").prepend('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message + '</div>');
                                } else {
                                    jQuery( "#admin-change-password .modal-header" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message +'</div>' );
                                }
                            },
                            error: function (data) {
                                jQuery( "#admin-change-password .modal-header" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Some error occured.</div>' );
                            }
                        });
                }
            } else {
                jQuery( "#admin-change-password .modal-header" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Fields are required.</div>' );
                jQuery( "#admin-change-password .modal-body .form-group" ).addClass('has-error');
            }
      });
});