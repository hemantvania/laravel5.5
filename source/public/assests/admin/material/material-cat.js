jQuery(function () {
    $("#tree").dynatree({
        fx: { height: "toggle", duration: 200 },
        autoCollapse: true,
        onActivate: function(node) {
            var catId = node.data.tooltip;
            if(node.data.title == "Add New Category") {
                $.get(+catId + '/addcategory', function (data) {

                    $('#myModal').modal();
                    $('#myModal').on('shown.bs.modal', function () {
                        $('#myModal .load_modal').html(data);
                    });
                    $('#myModal').on('hidden.bs.modal', function () {
                        $('#myModal .modal-body').data('');
                    });

                    $("#parentcat").val("afgasgasdg");
                });

                $("#echoActive").text(node.data.title);
            }
        },
        onDeactivate: function(node) {
            $("#echoActive").text("-");
        }
    });
    $("#cbAutoCollapse")
        .attr("checked", true) // set state, to prevent caching
        .click(function(){
            var f = $(this).attr("checked");
            $("#tree").dynatree("option", "autoCollapse", f);
        });
    $("#cbEffects")
        .attr("checked", true) // set state, to prevent caching
        .click(function(){
            var f = $(this).attr("checked");
            if(f){
                $("#tree").dynatree("option", "fx", { height: "toggle", duration: 200 });
            }else{
                $("#tree").dynatree("option", "fx", null);
            }
        });
    $("#skinCombo")
        .val(0) // set state to prevent caching
        .change(function(){
            var href = "../src/"
                + $(this).val()
                + "/ui.dynatree.css"
                + "?reload=" + new Date().getTime();
            $("#skinSheet").attr("href", href);
        });

    $('[data-toggle="modal"]').click(function(e) {
        var catId = $(this).attr('data-id');
        $.get( + catId +'/addcategory', function( data ) {

            $('#myModal').modal();
            $('#myModal').on('shown.bs.modal', function(){
                $('#myModal .load_modal').html(data);
            });
            $('#myModal').on('hidden.bs.modal', function(){
                $('#myModal .modal-body').data('');
            });

            $("#parentcat").val("afgasgasdg");
        });

    });

    $('body').on('click','#add-material-cat',function(e){
        e.preventDefault();

        var parentId = jQuery('#parentcat').val();
        var catName = jQuery('#catname').val();
        var token = jQuery('input:hidden[name=_token]').val();
        if( catName != '') {
            jQuery.ajax({
                type: "POST",
                url: '/admin/materials/addcategory',
                beforeSend: function (xhr) {
                    if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: {'catName': catName, 'parentId': parentId},
                success: function (data) {
                    if (data.status) {
                        jQuery("#myModal .modal-header").prepend('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message + '</div>');
                        jQuery('#catname').val('');
                    } else {
                        jQuery("#myModal .modal-header").prepend('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message + '</div>');
                    }
                    //console.log(data);
                },
                error: function (data) {

                }
            });
        } else {
            jQuery( "#myModal .modal-header" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Field is required.</div>' );
            jQuery( "#myModal .modal-body .form-group" ).addClass('has-error');
        }
    });

    $('body').on('click','#close-cat-modal',function(){
        $('#myModal').modal('toggle');
    });


});