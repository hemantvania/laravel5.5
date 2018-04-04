jQuery(function () {

    jQuery("#country").change(function(){
        var countryVal = jQuery("#country").val();
        var roleid = jQuery('#hid_userrole').val();
        if(!roleid) { roleid =0 ;}
        jQuery(".loadmoreimg").show();
        jQuery.ajax({
            url: "/admin/userrolelist/" + countryVal+'/'+roleid,
            type: 'GET',
            data: countryVal,
            success: function( data ) {
                if ( data.status == true ) {
                    jQuery('#userrole').html(data.list);
                } else {
                    jQuery('#userrole').html(data.list);
                }
                jQuery(".loadmoreimg").hide();
            },
            error: function( data ) {
                if ( data.status === false) {
                    jQuery('#userrole').html(data.list);
                }
                jQuery(".loadmoreimg").hide();
            }
        });
        return false;
    });

    jQuery('#userrole').on('change', function () {
        var isId = jQuery(this).val();
        if(isId == 2) // Teacher
        {
            jQuery('#schoollist').attr('multiple','multiple');
        }
        else
        {
            jQuery('#schoollist').removeAttr('multiple');
           // jQuery('#schoollist option:selected').remove();
        }
    })
    /*jQuery("#postal_code").on('blur', function(e) {
        var Code = jQuery(this).val();
        var Country = jQuery("#country").val();
        jQuery(".loading-mask").show();
        jQuery(".has-error .help-block").remove();
        jQuery("#postal_code").closest('.form-group').removeClass('has-error');

        jQuery.ajax({
            url: "/admin/zipvalidate/" + Code +'/'+Country,
            type: 'GET',
            data: Code,
            success: function( data ) {
                if(data.status == false )
                {
                    jQuery("#postal_code").after('<span class="help-block"><strong>Invalid Postal Code.</strong></span>');
                    jQuery("#postal_code").closest('.form-group').addClass('has-error');
                }
            },
            error: function( data ) {
                jQuery("#postal_code").after('<span class="help-block"><strong>Invalid Postal Code.</strong></span>');
                jQuery("#postal_code").closest('.form-group').addClass('has-error');
            }
        });

        jQuery(".loading-mask").hide();
    });

    jQuery(document).on('submit','#addedit_user----', function(e) {
        var Code = jQuery("#postal_code").val();
        var Country = jQuery("#country").val();
       // e.preventDefault();
        jQuery.ajax({
            url: "/admin/zipvalidate/" + Code +'/'+Country,
            type: 'GET',
            data: Code,
            success: function( data ) {

                if(data.status)
                {
                    alert('submit');
                    jQuery(".has-error .help-block").remove();
                    jQuery("#postal_code").closest('.form-group').removeClass('has-error');

                }
                else
                {

                    alert('prevemt');
                    jQuery("#postal_code").after('<span class="help-block"><strong>Invalid Postal Code.</strong></span>');
                    jQuery("#postal_code").closest('.form-group').addClass('has-error');
                    return false;
                }
            },
            error: function( data ) {
                e.preventDefault();
                jQuery("#postal_code").after('<span class="help-block"><strong>Invalid Postal Code.</strong></span>');
                jQuery("#postal_code").closest('.form-group').addClass('has-error');
                return false;
            }
        });
    });*/
});
