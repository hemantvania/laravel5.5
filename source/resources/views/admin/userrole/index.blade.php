@extends("admin.layout.default")

@section('title', __('adminuserrole.title'))

@section("page-css")
    <link rel="stylesheet" href="{{ asset('assests/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section("content")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
		
            <h1>@lang('adminuserrole.title')</h1>
        </section>

        <!-- Main content -->
        <section class="content">

            @include("error.adminmessage")

            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">@lang('adminuserrole.title')</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="userrole-list" class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th>@lang('adminuserrole.rolename')</th>
                                        <th>@lang('adminuserrole.status')</th>
                                        <th>@lang('adminuserrole.action')</th>
                                     </tr>
                                </thead>

                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->



@endsection


@section("page-js")

    <script src="{{ asset('assests/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assests/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    {{--<script type="text/javascript" src="{{ asset('assests/admin/userrole/userrole.js') }}"></script>--}}
    <script>
    jQuery(function () {
        var userroletable = jQuery('#userrole-list').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! url('admin/usersrolelistajax') !!}',
            columns: [
                { data: 'rolename', name: 'rolename' },
                { data: 'isactive', name: 'isactive' },
                { data: 'action', name: 'action' }
            ]
         });

          userroletable.on( 'draw', function () {
                /**
                 * Function is use for delete records
                 */
                jQuery(".remove-userrole").unbind().click( function(e) {
                    e.preventDefault();
                    var id = jQuery(this).attr("data-index");
                    jQuery('#confirmDelete').attr('data-id',id);
                    jQuery('#confirmDelete').modal('show');
                });

                /**
                 * Fire Ajax Call on click "Yes" button
                 */
                jQuery("#btnYes").unbind().click(function(e){
                    // handle deletion here
                    var roleId = jQuery('#confirmDelete').attr('data-id');
                    jQuery('#confirmDelete').modal('hide');
                    jQuery(".loadmoreimg").show();
                    jQuery(".alert-success").remove();
                    jQuery(".alert-danger").remove();

                    jQuery.ajax({
                        url: "/admin/userrole/" + roleId + '/delete',
                        type: 'GET',
                        data: roleId,
                        success: function (data) {
                            if (data.status == true) {
                                jQuery(".content-wrapper .content").prepend('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message + '</div>');
                                jQuery(".dataTable tr#" + roleId).remove();
                            } else {
                                jQuery(".content-wrapper .content").prepend('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message + '</div>');
                            }
                            userroletable.ajax.reload();
                            jQuery(".loadmoreimg").hide();
                        },

                        error: function (data) {
                            if (data.status === false) {
                                jQuery(".content-wrapper .content").prepend('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + data.message + '</div>');
                            }
                            jQuery(".loadmoreimg").hide();
                        }
                    });
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
                                userroletable.ajax.reload();
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
    </script>
@endsection