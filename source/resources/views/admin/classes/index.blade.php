@extends("admin.layout.default")

@section('title', __('adminclasses.title'))

@section("page-css")
    <link rel="stylesheet" href="{{ asset('assests/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section("content")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
		
            <h1>@lang('adminclasses.title')</h1>

		</section>

        <!-- Main content -->
        <section class="content">

            @include("error.adminmessage")

            <div class="row">
                <div class="col-xs-12">


                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">@lang('adminclasses.title')</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="classeslist" class="table table-bordered table-striped">

                                <thead>
                                    <tr>
                                        <th>@lang('adminclasses.classname')</th>
                                        <th>@lang('adminclasses.schoolname')</th>
                                        <th>@lang('adminclasses.educationtype')</th>
                                        <th>@lang('adminclasses.standard')</th>
                                        <th>@lang('adminclasses.action')</th>
                                     </tr>
                                </thead>
                                <div class="loading-mask" style="display: none;"></div>

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
            var classestable = jQuery('#classeslist').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! url('admin/classlist') !!}',
                columns: [

                    { data: 'className', name: 'classes.className' },
                    { data: 'schoolName', name: 'schools.schoolName' },
                    { data: 'educationName', name: 'education_types.educationName' },
                    { data: 'standard', name: 'classes.standard' },
                    { data: 'action', name: 'action' }
                ]
            });

            classestable.on( 'draw', function () {
                /**
                 * Function is use for delete records
                 */
                jQuery(".remove-class").unbind().click( function(e) {
                    e.preventDefault();
                    var classId = jQuery(this).attr("data-index");
                    jQuery('#confirmDelete').attr('data-id',classId);
                    jQuery('#confirmDelete').modal('show');
                });

                /**
                 * Fire Ajax Call on click "Yes" button
                 */
                jQuery("#btnYes").unbind().click(function(e) {
                    // handle deletion here
                    var classId = jQuery('#confirmDelete').attr('data-id');
                    jQuery('#confirmDelete').modal('hide');
                    jQuery(".alert-success").remove();
                    jQuery(".alert-danger").remove();
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
                            classestable.ajax.reload();
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
                            } else {
                                jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                            }
                            classestable.ajax.reload();
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