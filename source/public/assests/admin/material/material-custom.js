jQuery( document ).ready(function() {
    jQuery("#materialType").change(function () {
        if(this.value == "Link"){

            jQuery("#uploadcontent").val('');
            jQuery("#upload-contents").hide();
            jQuery("#upload-externalurl").show();
		} else {

            jQuery("#thirdPartyLink").val('');
            jQuery("#upload-contents").show();
            jQuery("#upload-externalurl").hide();
        }
    });
	
	$('textarea').keypress(function(e) {
		var tval = $('textarea').val(),
			tlength = tval.length,
			set = 500,
			remain = parseInt(set - tlength);
			$('p').text(remain);
			if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
				$('textarea').val((tval).substring(0, tlength - 1));
				return false;
			}
	})
});
		 

