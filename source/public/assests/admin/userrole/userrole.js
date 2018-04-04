jQuery(function () {
    /*jQuery('#example1').DataTable()
    jQuery('#example2').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
    });*/

    var usertable = jQuery('#userrole-list').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'http://edesk.local/admin/usersrolelistajax',
        columns: [
             { data: 'rolename', name: 'userroles.rolename' },
             { data: 'isactive', name: 'userroles.isactive' },
             { data: 'action', name: 'action' }
        ]
    });

    usertable.on( 'draw', function () {
        /**
         * Function is use for delete records
         */
        jQuery(".remove-userrole").on('click', function(e) {
            jQuery(".loadmoreimg").show();
            var roleId = jQuery(this).attr("data-index");
            jQuery( ".alert-success").remove();
            jQuery( ".alert-danger").remove();
            jQuery.ajax({
                url: "/admin/userrole/" + roleId +'/delete',
                type: 'GET',
                data: roleId,
                success: function( data ) {
                    if ( data.status == true ) {
                        jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                        jQuery(".dataTable tr#"+roleId).remove();
                    } else {
                        jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                    }
                    jQuery(".loadmoreimg").hide();
                },
                error: function( data ) {
                    if ( data.status === false) {
                        jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                    }
                    jQuery(".loadmoreimg").hide();
                }
            });

            return false;
        });


        /**
         * Function is use for restore deleted records
         */
        jQuery(".restore-userrole").on('click', function(e) {
            jQuery(".loadmoreimg").show();
            var roleId = jQuery(this).attr("data-index");
            jQuery( ".alert-success").remove();
            jQuery( ".alert-danger").remove();
            jQuery.ajax({
                url: "/admin/userrole/" + roleId +'/restore',
                type: 'GET',
                data: roleId,
                success: function( data ) {
                    if ( data.status == true ) {
                        jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                        //jQuery(".dataTable tr#"+roleId).remove();

                    } else {
                        jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                    }
                    jQuery(".loadmoreimg").hide();
                },
                error: function( data ) {
                    if ( data.status === false) {
                        jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                    }
                    jQuery(".loadmoreimg").hide();
                }
            });

            return false;
        });
    });
});