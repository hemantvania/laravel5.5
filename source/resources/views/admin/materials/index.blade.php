@extends("admin.layout.default")

@section('title', __('adminmaterial.title'))

@section("page-css")
    <link rel="stylesheet" href="{{ asset('assests/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section("content")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
		
            <h1>@lang('adminmaterial.title')</h1>

		</section>

        <!-- Main content -->
        <section class="content">

            @include("error.adminmessage")

            <div class="row">
                 <div class="col-xs-12">
                     <div class="box">
                         <div class="box-header">
                             <h3 class="box-title">@lang('adminmaterial.title')</h3>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">

                         <table class="table table-bordered table-striped" id="material-table">
                             <thead>
                             <tr>
                                 <th>@lang('adminmaterial.materialname')</th>
                                 <th>@lang('adminmaterial.description')</th>
                                 <th>@lang('adminmaterial.type')</th>
                                 <th>@lang('general.action')</th>
                             </tr>
                             </thead>
                         </table>
                         </div>
                         <!-- /.box-body -->
                     </div>
                     <!-- /.box -->
                 </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@section("page-js")

    <script src="{{ asset('assests/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assests/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <script>
        jQuery(function() {
          var materiallist = jQuery('#material-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! url('admin/materialslist') !!}',
                columns: [
                    { data: 'materialName', name: 'materials.materialName' },
                    { data: 'description', name: 'materials.description' },
                    { data: 'materialType', name: 'materials.materialType' },
                    { data: 'action', name: 'action' }
                ]
            });

            materiallist.on( 'draw', function () {
                /**
                 * Function is content for delete records
                 */
                jQuery(".remove-contents").unbind().click( function(e) {
                    e.preventDefault();
                    var contentId = jQuery(this).attr("data-index");
                    jQuery('#confirmDelete').attr('data-id',contentId);
                    jQuery('#confirmDelete').modal('show');
                });

                jQuery('#global_search').on( 'keyup click', function () {
                    materiallist.search(
                        jQuery('#global_search').val()
                    ).draw();
                });
                /**
                 * Fire Ajax Call on click "Yes" button
                 */
                jQuery("#btnYes").unbind().click(function(e) {
                    // handle deletion here
                    var contentId = jQuery('#confirmDelete').attr('data-id');

                    jQuery('#confirmDelete').modal('hide');
                    jQuery( ".alert-success").remove();
                    jQuery( ".alert-danger").remove();
                    jQuery.ajax({
                        url: "/admin/materials/" + contentId +'/delete',
                        type: 'GET',
                        data: contentId,
                        success: function( data ) {
                            if ( data.status == true ) {
                                jQuery(".content-wrapper .content").prepend('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message + '</div>');

                            } else {
                                jQuery(".content-wrapper .content").prepend('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message + '</div>');
                            }
                            materiallist.ajax.reload();
                            jQuery(".loadmoreimg").hide();
                        },
                        error: function( data ) {
                            if ( data.status === false) {
                                jQuery(".content-wrapper .content").prepend('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message + '</div>');
                            }
                            materiallist.ajax.reload();
                            jQuery(".loadmoreimg").hide();

                        }
                    });
                });

                /**
                 * Function is use for restore deleted records
                 */
                jQuery(".restore-contents").on('click', function(e) {
                    jQuery(".loadmoreimg").show();
                    var contentId = jQuery(this).attr("data-index");
                    jQuery( ".alert-success").remove();
                    jQuery( ".alert-danger").remove();
                    jQuery.ajax({
                        url: "/admin/materials/" + contentId +'/restore',
                        type: 'GET',
                        data: contentId,
                        success: function( data ) {
                            if ( data.status == true ) {
                                jQuery(".content-wrapper .content").prepend('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message + '</div>');
                            } else {
                                jQuery(".content-wrapper .content").prepend('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message + '</div>');
                            }
                            materiallist.ajax.reload();
                            jQuery(".loadmoreimg").hide();
                        },
                        error: function( data ) {
                            if ( data.status === false) {
                                jQuery(".content-wrapper .content").prepend('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message + '</div>');
                            }
                            materiallist.ajax.reload();
                            jQuery(".loadmoreimg").hide();
                        }
                    });

                    return false;
                });

            });

        });
    </script>
@endsection