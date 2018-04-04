@extends('layouts.vdesk')
@section("page-css")

    <link rel="stylesheet" href="{{ asset('plugins/datatables.net/css/dataTables.bootstrap.css') }}">

@endsection
@section('content')
    @include("error.message")
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
                <div class="scroll-main-wrapper2">
                <div class="col-sm-12">
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="aineisto" aria-labelledby="aineisto-tab">
                            <div class="material-tab">
                                <div class="material-filter">
                                    <div class="row">
                                        <ul class="clearfix">
                                            <li class="search-filter col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="search-filter-main" id="adv-search">
                                                            <input type="text" id="global_search" class="form-control select2" placeholder="@lang('schooladmin.classes_search_title')" />
                                                        </div>
                                                    </div>
                                                </div>
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
                </div></div>
        </div>
    </section>
@endsection
@section("scripts")

    <script src="{{ asset('assests/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assests/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <script type="text/javascript">
        jQuery(function() {

            var edeskerrorMsg = '@lang('teacher.select_class_show')';
            var classesUrl = '{!! generateLangugeUrl(App::getLocale(),url(generateUrlPrefix())) !!}';

            var lbl_cname   = "@lang('adminclasses.classname')";
            var lbl_sname   = "@lang('adminclasses.schoolname')";
            var lbl_type    = "@lang('adminclasses.educationtype')";
            var lbl_std     = "@lang('adminclasses.standard')";
            var lbl_name    = "@lang('adminclasses.assigned_teacher')";
            var lbl_act     = "@lang('adminclasses.action')";

            var classestable = jQuery('#classeslist').DataTable({
                processing: true,
                serverSide: true,
                ajax: classesUrl+ '/classlist',
                columns: [

                    { data: 'className', name: 'classes.className' },
                    { data: 'schoolName', name: 'schools.schoolName' },
                    { data: 'educationName', name: 'education_types.educationName' },
                    { data: 'standard', name: 'classes.standard' },
                    { data: 'name', name: 'users.name' },
                    { data: 'action', name: 'action' }
                ],
                'columnDefs': [
                    {
                        'targets': 5,
                        'searchable': false,
                        'orderable': false,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_act);
                        }
                    },
                    {
                        'targets': 0,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_cname);
                        },
                    },
                    {
                        'targets': 1,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_sname);
                        },
                    },
                    {
                        'targets': 2,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_type);
                        },
                    },
                    {
                        'targets': 3,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_std);
                        },
                    },
                    {
                        'targets': 4,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_name);
                        },
                    },
                ]
            });

            jQuery('#global_search').on( 'keyup click', function () {
                classestable.search(
                    jQuery('#global_search').val()
                ).draw();
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
                    showloader();
                    jQuery.ajax({
                        url: classesUrl+"/classes/" + classId +'/delete',
                        type: 'GET',
                        data: classId,
                        success: function( data ) {
                            if ( data.status == true ) {
                                showmessage(data.message);
                            } else {
                                showmessage(data.message);
                            }
                            classestable.ajax.reload();
                            showloader();
                        },
                        error: function( data ) {
                            if ( data.status === false) {
                                showmessage(data.message);
                            }
                            showloader();
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
                    showloader();
                    jQuery.ajax({
                        url: classesUrl+"/classes/" + classId +'/restore',
                        type: 'GET',
                        data: classId,
                        success: function( data ) {
                            if ( data.status == true ) {
                                showmessage(data.message);
                            } else {
                                showmessage(data.message);
                            }
                            classestable.ajax.reload();
                            showloader();
                        },
                        error: function( data ) {
                            if ( data.status === false) {
                                showmessage(data.message);
                            }
                            showloader();
                        }
                    });

                    return false;
                });
            });

        });
    </script>
@endsection