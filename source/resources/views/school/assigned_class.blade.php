@extends('layouts.vdesk')
@section("page-css")
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assests/admin/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('assests/admin/bower_components/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assests/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

@endsection
@section('content')

    <section class="content-wrapper">
        <div class="container-fluid inner-contnet-wrapper">
            <div class="tab-wrapper">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 user-details">
                        @include("comman.school-nav")
                    </div>
                    @include("comman.navigation")
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="aineisto" aria-labelledby="aineisto-tab">
                            <div class="material-tab">
                                <div class="material-filter">
                                    <div class="row">
                                        <ul class="clearfix">
                                            <li class="search-filter col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <select id="global_filter" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" >
                                                    <option value="0" selected>Search for Teacher</option>
                                                    <option value="1">Material 1</option>
                                                    <option value="2">Material 2</option>
                                                    <option value="3">Material 3</option>
                                                    <option value="4">Material 4</option>
                                                    <option value="5">Material 5</option>
                                                </select>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="materialtable">
                                    <table class="gridtable table-bordered" id="classeslist" width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <thead>
                                        <tr>
                                            <th>@lang('adminclasses.classname')</th>
                                            <th>@lang('adminclasses.schoolname')</th>
                                            <th>@lang('adminclasses.educationtype')</th>
                                            <th>@lang('adminclasses.standard')</th>
                                            <th>@lang('adminclasses.assigned_teacher')</th>
                                            <th>@lang('adminclasses.action')</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section("scripts")

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
                    { data: 'name', name:'users.name'},
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
                                showmessage(data.message);
                            } else {
                                showmessage(data.message);
                            }
                            classestable.ajax.reload();
                            jQuery(".loadmoreimg").hide();
                        },
                        error: function( data ) {
                            if ( data.status === false) {
                                showmessage(data.message);
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
                                showmessage(data.message);
                            } else {
                                showmessage(data.message);
                            }
                            classestable.ajax.reload();
                            jQuery(".loadmoreimg").hide();
                        },
                        error: function( data ) {
                            if ( data.status === false) {
                                showmessage(data.message);
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