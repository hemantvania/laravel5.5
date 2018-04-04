@extends("admin.layout.default")

@section('title', __('adminschool.title'))

@section("page-css")
    <link rel="stylesheet" href="{{ asset('assests/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section("content")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>@lang('adminschool.title')</h1>

        </section>

        <!-- Main content -->
        <section class="content">

            @include("error.adminmessage")

            <div class="row">
                <div class="col-xs-12">


                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">@lang('adminschool.title')</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="schoollist" class="table table-bordered table-striped">

                                <thead>
                                <tr>
                                    <th>@lang('adminschool.schoolname')</th>
                                    <th>@lang('adminschool.contact_person_email')</th>
                                    <th>@lang('adminschool.registrationNo')</th>
                                    <th>@lang('adminschool.address')</th>
                                    <th>@lang('adminschool.weburl')</th>
                                    <th>@lang('adminschool.action')</th>
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
    <script type="text/javascript">
        jQuery(function() {
            var schooltable = jQuery('#schoollist').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! url('admin/schoollist') !!}',
                columns: [

                    {data: 'schoolName', name: 'schoolName'},
                    {data: 'email', name: 'email'},
                    {data: 'registrationNo', name: 'registrationNo'},
                    {data: 'WebUrl', name: 'WebUrl'},
                    {data: 'address1', name: 'address1'},
                    {data: 'action', name: 'action'}
                ]
            });

            schooltable.on( 'draw', function () {

                /**
                 * Function is use for delete records
                 */
                jQuery(".remove-school").unbind().click(function(e) {
                    e.preventDefault();
                    var schoolId = jQuery(this).attr("data-index");
                    jQuery('#confirmDelete').attr('data-id',schoolId);
                    jQuery('#confirmDelete').modal('show');
                });

                /**
                 * Fire Ajax Call on click "Yes" button
                 */
                jQuery("#btnYes").unbind().click(function(e) {
                    e.preventDefault();
                    // handle deletion here
                    var schoolId = jQuery('#confirmDelete').attr('data-id');
                    jQuery('#confirmDelete').modal('hide');
                    jQuery(".alert-success").remove();
                    jQuery(".alert-danger").remove();
                    jQuery.ajax({
                        url: "/admin/schools/" + schoolId +'/delete',
                        type: 'GET',
                        data: schoolId,
                        success: function( data ) {
                            if ( data.status == true ) {
                                jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                                schooltable.ajax.reload();
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
                   console.log('Here');
                });


                /**
                 * Function is use for restore deleted records
                 */
                jQuery(".restore-school").on('click', function(e) {
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
                            } else {
                                jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                            }
                            schooltable.ajax.reload();
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