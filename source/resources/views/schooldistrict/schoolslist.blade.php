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
                    @include("comman.discrict-nav")
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
@section('scripts')
    <script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        var lbl_sname = "@lang('adminschool.schoolname')";
        var lbl_email = "@lang('adminschool.contact_person_email')";
        var lbl_rgNo = "@lang('adminschool.registrationNo')";
        var lbl_addr = "@lang('adminschool.address')";
        var lbl_web = "@lang('adminschool.weburl')";


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
            ],
            'columnDefs': [
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
    </script>
@endsection