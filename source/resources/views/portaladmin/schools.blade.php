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
                        @include("comman.admin-nav")
                    </div>
                    @include("comman.navigation")
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
                                                                <input type="text" id="global_search" class="form-control select2" placeholder="@lang('portaladmin.school_search_title')" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="materialtable materialtable-teacher">
                                        <table class="gridtable table-bordered" id="schoollist" width="100%" border="0" cellspacing="0" cellpadding="0" >
                                            <thead>
                                            <tr>
                                                <th>@lang('adminschool.schoolname')</th>
                                                <th>@lang('adminschool.contact_person_email')</th>
                                                <th>@lang('adminschool.registrationNo')</th>
                                                <th>@lang('adminschool.weburl')</th>
                                                <th>@lang('adminschool.address')</th>
                                                <th>@lang('adminschool.action')</th>
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
            </div>
    </section>
@endsection
@section("scripts")
    <script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
    <script>

        var schoolUrl = "{!! generateLangugeUrl(App::getLocale(),url(generateUrlPrefix().'/schools/')) !!}/";

        var lbl_sname = "@lang('adminschool.schoolname')";
        var lbl_email = "@lang('adminschool.contact_person_email')";
        var lbl_rgNo = "@lang('adminschool.registrationNo')";
        var lbl_addr = "@lang('adminschool.address')";
        var lbl_web = "@lang('adminschool.weburl')";
        var lbl_act = "@lang('adminschool.action')";

        jQuery(function() {
            var schooltable = jQuery('#schoollist').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! generateLangugeUrl(App::getLocale(),url(generateUrlPrefix().'/schoolslist/')) !!}',
                columns: [

                    {data: 'schoolName', name: 'schoolName'},
                    {data: 'email', name: 'email'},
                    {data: 'registrationNo', name: 'registrationNo'},
                    {data: 'WebUrl', name: 'WebUrl'},
                    {data: 'address1', name: 'address1'},
                    {data: 'action', name: 'action'}
                ],
                'columnDefs': [
                    {
                        'targets': 5,
                        'searchable': false,
                        'orderable': false,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_act);
                        },
                    },
                    {
                        'targets': 0,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_sname);
                        },
                    },
                    {
                        'targets': 1,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr({'data-label':lbl_email, 'title': rowData.email});
                        },
                        render: function ( data, type, row ) {
                            return getLimitedString(data,15);
                        }
                    },
                    {
                        'targets': 2,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_rgNo);
                        },
                    },
                    {
                        'targets': 3,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr({'data-label':lbl_web, 'title': rowData.WebUrl});
                        },
                        render: function ( data, type, row ) {
                            return getLimitedString(data, 10);
                        }
                    },
                    {
                        'targets': 4,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_addr);
                        },

                    },
                ]
            });

            jQuery('#global_search').on( 'keyup click', function () {
                schooltable.search(
                    jQuery('#global_search').val()
                ).draw();
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
                    showloader();
                    // handle deletion here
                    var schoolId = jQuery('#confirmDelete').attr('data-id');
                    jQuery('#confirmDelete').modal('hide');
                    jQuery(".alert-success").remove();
                    jQuery(".alert-danger").remove();
                    jQuery.ajax({
                        url: schoolUrl + schoolId +'/delete',
                        type: 'GET',
                        data: schoolId,
                        success: function( data ) {
                            if ( data.status == true ) {
                                showmessage(data.message);
                                //schooltable.ajax.reload();
                                schooltables.draw(false);
                            } else {
                                showmessage(data.message);
                            }

                            showloader();
                        },
                        error: function( data ) {
                            if ( data.status === false) {
                                jQuery( ".content-wrapper .content" ).prepend( '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+data.message+'</div>' );
                            }
                            showloader();
                        }
                    });
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
                        url: schoolUrl+ schoolId +'/restore',
                        type: 'GET',
                        data: schoolId,
                        success: function( data ) {
                            if ( data.status == true ) {
                                showmessage(data.message);
                            } else {
                                showmessage(data.message);
                            }
                            schooltable.ajax.reload();
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