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
                                        <table class="gridtable table-bordered" id="materialsreportlist" width="100%" border="0" cellspacing="0" cellpadding="0" >
                                            <thead>
                                            <tr>
                                                <th>@lang('adminschool.schoolname')</th>
                                                <th>@lang('schooldisctrict.label_classname')</th>
                                                <th>@lang('schooldisctrict.label_video')</th>
                                                <th>@lang('schooldisctrict.label_audio')</th>
                                                <th>@lang('schooldisctrict.label_link')</th>
                                                <th>@lang('schooldisctrict.label_pdf')</th>
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
        var materialslist = jQuery('#materialsreportlist').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! generateLangugeUrl(App::getLocale(),url(generateUrlPrefix().'/materilaslist/')) !!}',
            columns: [
                {data: 'schoolName', name: 'schoolName'},
                {data: 'className', name: 'className'},
                {data: 'totalvideo', name:'totalvideo'},
                {data: 'totalaudio', name:'totalaudio'},
                {data: 'totallinks', name:'totallinks'},
                {data: 'totalpdf', name:'totalpdf'},
            ],
        });
        jQuery('#global_search').on( 'keyup click', function () {
            materialslist.search(
                jQuery('#global_search').val()
            ).draw();
        });
    </script>
@endsection