@extends("admin.layout.default")

@section('title', __('adminuser.title'))

@section("page-css")
    <link rel="stylesheet" href="{{ asset('assests/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section("content")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                @lang('adminuser.teachers_management')
                <small>List</small>
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            @include("error.adminmessage")

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> @lang('adminuser.teachers_management')</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <table class="table table-bordered table-striped" id="teachers_list">
                                <thead>
                                <tr>
                                    <th>@lang('adminuser.first_name')</th>
                                    <th>@lang('adminuser.last_name')</th>
                                    <th>@lang('adminuser.email')</th>
                                    <th>@lang('adminuser.usertype')</th>
                                    <th>@lang('adminuser.phone')</th>
                                    <th>@lang('adminuser.address')</th>
                                    <th>@lang('adminuser.action')</th>
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
            var teacherlist = jQuery('#teachers_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! url('admin/schools/teacherslist') !!}',
                columns: [

                    { data: 'first_name', name: 'users.first_name' },
                    { data: 'last_name', name: 'users.last_name' },
                    { data: 'email', name: 'users.email' },
                    { data: 'rolename', name: 'userroles.rolename' },
                    { data: 'phone', name: 'user_metas.phone' },
                    { data: 'addressline1', name: 'user_metas.addressline1' },
                    { data: 'action', name: 'action' }
                ]
            });

            teacherlist.on( 'draw', function () {

                /**
                 * Function is use for delete records
                 */
                jQuery(".remove-adminusers").unbind().click( function(e) {
                    e.preventDefault();
                    var userId = jQuery(this).attr("data-index");
                    jQuery('#confirmDelete').attr('data-id',userId);
                    jQuery('#confirmDelete').modal('show');
                });

                /**
                 * Fire Ajax Call on click "Yes" button
                 */
                jQuery("#btnYes").unbind().click(function(e) {
                    // handle deletion here
                    var userId = jQuery('#confirmDelete').attr('data-id');
                    jQuery('#confirmDelete').modal('hide');
                    jQuery( ".alert-success").remove();
                    jQuery( ".alert-danger").remove();
                    jQuery.ajax({
                        url: "/admin/users/" + userId +'/destroy',
                        type: 'GET',
                        data: userId,
                        success: function( data ) {
                            if ( data.status == true ) {
                                jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                                jQuery(".dataTable tr#"+userId).remove();
                            } else {
                                jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                            }
                            teacherlist.ajax.reload();
                            jQuery(".loadmoreimg").hide();
                        },
                        error: function( data ) {
                            if ( data.status === false) {
                                jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                            }
                            jQuery(".loadmoreimg").hide();
                        }
                    });
                });


                /**
                 * Function is use for restore deleted records
                 */
                jQuery(".restore-adminusers").on('click', function(e) {
                    jQuery(".loadmoreimg").show();
                    var userId = jQuery(this).attr("data-index");
                    jQuery( ".alert-success").remove();
                    jQuery( ".alert-danger").remove();
                    jQuery.ajax({
                        url: "/admin/users/" + userId +'/restore',
                        type: 'GET',
                        data: userId,
                        success: function( data ) {
                            if ( data.status == true ) {
                                jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                            } else {
                                jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                            }
                            teacherlist.ajax.reload();
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