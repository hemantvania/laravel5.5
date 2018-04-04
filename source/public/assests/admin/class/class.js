jQuery(function () {
    jQuery('#classeslist').DataTable()
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

    jQuery(".remove-class").on('click', function(e) {
        var conf = confirm('Are you sure to delete this Class?');

        if(!conf)
        {
            return false;
        }

        jQuery(".loadmoreimg").show();
        var classId = jQuery(this).attr("data-index");
        jQuery( ".alert-success").remove();
        jQuery( ".alert-danger").remove();
        jQuery.ajax({
            url: "/admin/classes/" + classId +'/delete',
            type: 'GET',
            data: classId,
            success: function( data ) {
                if ( data.status == true ) {
                    jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                    jQuery(".dataTable tr#"+classId).remove();

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
    jQuery(".restore-class").on('click', function(e) {
        jQuery(".loadmoreimg").show();
        var classId = jQuery(this).attr("data-index");
        jQuery( ".alert-success").remove();
        jQuery( ".alert-danger").remove();
        jQuery.ajax({
            url: "/admin/classes/" + classId +'/restore',
            type: 'GET',
            data: classId,
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