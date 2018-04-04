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
                                                                <input type="text" id="global_search" class="form-control select2" placeholder="@lang('portaladmin.content_search_title')" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="share-filter col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                                    <button class="btn btn-vdesk" id="delete_selected">@lang('portaladmin.btn_delete_selected')</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="materialtable materialtable-teacher">
                                        <table class="gridtable table-bordered" id="material-table" width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <thead>

                                            <tr>
                                                <th class="thbold" width="50px;">
                                                    <input name="select_all_material" value="1" id="material-select-all" type="checkbox">
                                                    <label for="material-select-all" id="materialselect"></label>
                                                </th>
                                                <th>@lang('adminmaterial.name')</th>
                                                <th>@lang('adminmaterial.description')</th>
                                                <th>@lang('adminmaterial.label_type')</th>
                                                <th>@lang('general.action')</th>
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
        </div>
    </section>
    <div class="modal fade" id="select_materials" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">@lang('teacher.assign_material_select')</h4>
                </div>
                <div class="modal-body">
                    <p>@lang('teacher.assign_material_select')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-vdesk" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section("scripts")
    <script src="{{ asset('assests/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assests/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

    <script>

        var materialUrl     = "{!! generateLangugeUrl(App::getLocale(),url(generateUrlPrefix().'/materials/')) !!}/";
        var materialdelurl  = "{!! generateLangugeUrl(App::getLocale(),url(generateUrlPrefix().'/materials/deleteselected')) !!}";
        var lbl_mName   = "@lang('adminmaterial.name')";
        var lbl_desc    = "@lang('adminmaterial.description')";
        var lbl_type    = "@lang('adminmaterial.label_type')";
        var lbl_act     = "@lang('general.action')";

        jQuery(function() {
            var materiallist = jQuery('#material-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! url(App::getLocale().'/'. generateUrlPrefix().'/materialslist') !!}',
                columns: [
                    { data: 'delaction' },
                    { data: 'materialName', name: 'materials.materialName' },
                    { data: 'description', name: 'materials.description' },
                    { data: 'materialType', name: 'materials.materialType' },
                    { data: 'action', name: 'action' }
                ],
                'columnDefs': [
                    {
                        'targets': 0,
                        'searchable': false,
                        'orderable': false,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label','');
                        },
                        'render': function (data,type,full,meta) {
                            return '<input type="checkbox" id="material_'+full.id+'" name="materialsids[]" value="'+full.id+'" /><label for="material_'+full.id+'"></label>';
                        }
                    },
                    {
                        'targets': 4,
                        'searchable': false,
                        'orderable': false,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_act);
                        },
                    },
                    {
                        'targets': 1,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_mName);
                        },
						'render': function (data, type, full, meta){
                            return '<a href="'+full.link+'" target="_blank">'+data+'</a>';
                        }
                    },
                    {
                        'targets': 2,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_desc);
                        },
                    },
                    {
                        'targets': 3,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_type);
                        },
                    },
                ]
            });

            materiallist.on( 'draw', function () {
                /**
                 * Function is content for delete records
                 */
                jQuery(".remove-contents").unbind().click( function(e) {
                    e.preventDefault();
                    var userId = jQuery(this).attr("data-index");
                    jQuery('#confirmDelete').attr('data-id',userId);
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
                    showloader();
                    jQuery.ajax({
                        url: materialUrl + contentId +'/delete',
                        type: 'GET',
                        data: contentId,
                        success: function( data ) {
                            if ( data.status == true ) {
                                showmessage(data.message);
                            } else {
                                showmessage(data.message);
                            }
                         //   materiallist.ajax.reload();
                            materiallist.draw(false);

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
                jQuery(".restore-contents").on('click', function(e) {
                    showloader();
                    var contentId = jQuery(this).attr("data-index");
                    jQuery( ".alert-success").remove();
                    jQuery( ".alert-danger").remove();
                    jQuery.ajax({
                        url: materialUrl + contentId +'/restore',
                        type: 'GET',
                        data: contentId,
                        success: function( data ) {
                            if ( data.status == true ) {
                                showmessage(data.message);
                            } else {
                                showmessage(data.message);
                            }
                            materiallist.ajax.reload();
                            showloader();
                        },
                        error: function( data ) {
                            if ( data.status === false) {
                                showmessage(data.message);
                                materiallist.ajax.reload();
                            }
                            showloader();
                        }
                    });

                    return false;
                });


                /**
                 *  Check All Event
                 *
                 */
                jQuery('#material-select-all').on('click', function(){
                    // Get all rows with search applied
                    var rows = materiallist.rows({ 'search': 'applied' }).nodes();
                    // Check/uncheck checkboxes for all rows in the table
                    jQuery('input[type="checkbox"]', rows).prop('checked', this.checked);
                });



            });


            jQuery('#delete_selected').on('click',function(){
                showloader();
                var materialdata = materiallist.$('input[type="checkbox"]').serialize();
                if(materialdata !== ''){
                    materialdata =  materialdata;
                    jQuery.ajax({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        },
                        url: materialdelurl,
                        type: 'POST',
                        data: materialdata ,
                        success: function (data) {
                            showloader();
                            if(data.status === true){
                                showmessage(data.message);
                                materiallist.draw(false);
                            } else {
                                showerrormessage(data.message);
                            }

                        },
                        error: function (data) {
                            showloader();
                            if (data.status === false) {
                                showerrormessage(data.message);
                            }
                        }
                    });
                } else {
                    showloader();
                    jQuery("#select_materials").modal('show');
                }
            });
        });
    </script>
@endsection