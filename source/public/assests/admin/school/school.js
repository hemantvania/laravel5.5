jQuery(function () {
    jQuery('#schoollist').DataTable()
    jQuery('#example2').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
    });

    /**
     * Function is use for delete records
     */

    jQuery(".remove-school-old").on('click', function(e) {
        jQuery(".loadmoreimg").show();
        var schoolId = jQuery(this).attr("data-index");
        jQuery( ".alert-success").remove();
        jQuery( ".alert-danger").remove();
        jQuery.ajax({
            url: "/admin/schools/" + schoolId +'/delete',
            type: 'GET',
            data: schoolId,
            success: function( data ) {
                if ( data.status == true ) {
                    jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                    jQuery(".dataTable tr#"+schoolId).remove();
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
    jQuery(".restore-school-old").on('click', function(e) {
        jQuery(".loadmoreimg").show();
        var schoolId = jQuery(this).attr("data-index");
        jQuery( ".alert-success").remove();
        jQuery( ".alert-danger").remove();
        jQuery.ajax({
            url: "/admin/schools/" + schoolId +'/restore',
            type: 'GET',
            data: schoolId,
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