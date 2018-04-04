<div class="material-tab">
    <div class="material-filter">
        <div class="row">
            <ul class="clearfix">
                <li class="search-filter col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="search-filter-main" id="adv-search">
                                <input type="text" id="global_search" class="form-control select2" placeholder="@lang('teacher.label_m_search')" />
                            </div>
                            <button type="button" class="btn btn-default btn-dropdown-cust" id="but-stop-click"><span class="caret"></span></button>
                            <div class="teacher-search-filter dropdown-custom col-xs-12" role="menu">
                                <div class="form-group teacher-search-filter2">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-close pull-right close-advance" id="close-advance-search" onclick="window.location.href=#'"><i class="material-icons">close</i></button>
                                    </div>
                                    <div class="col-xs-12 teacher-search-type">
                                        <label class="col-lg-3 col-md-3 col-sm-12 col-xs-12 control-label">@lang('teacher.label_type')</label>
                                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                            <select id="type_filter" class="column_filter selectpicker">
                                                <option value="" selected>@lang('teacher.label_type')</option>
                                                @foreach ($types as $type)
                                                    <option value="{{$type->materialType}}">{{$type->materialType}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 teacher-search-owner">
                                        <label class="col-lg-3 col-md-3 col-sm-12 col-xs-12 control-label">@lang('teacher.label_owner')</label>
                                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                            <select id="owner_filter" class="selectpicker">
                                                <option value="" selected>@lang('teacher.label_owner')</option>
                                                @foreach ($owners as $owner)
                                                    <option value="{{$owner->ownerid}}">{{$owner->fullname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="pull-right teacher-search-btn">
                                            <span><a href="javascript:void(0);" id="btn_clear" class="chat-cancel-btn">@lang('teacher.label_ad_search_clear')</a></span>
                                            <button type="submit" class="btn btn-secondary btn-search ">@lang('teacher.label_ad_search')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="share-filter col-lg-2 col-md-4 col-sm-6 col-xs-12">
                    <select class="selectpicker" id="assign_materials" data-url="{{ generateLangugeUrl( App::getLocale(),url('teacher/material/assign'))}}">
                        <option value="0">@lang('general.jaamaterial')</option>
                        @foreach($classes as $class)
                            <option value="{{$class->id}}"> {{$class->className}}</option>
                        @endforeach
                    </select>
                </li>

            </ul>
        </div>
    </div>
    <div class="materialtable">
        <table id="materiallist" width="100%" border="0" cellspacing="0" cellpadding="0" class="gridtable table-bordered">
            <thead>
            <th class="thbold" width="50px;">
                <input name="select_all_material" value="1" id="material-select-all" type="checkbox">
                <label for="material-select-all" id="materialselect"></label>
            </th>
            <th class="thbold">@lang('teacher.label_material_name')</th>
            <th class="thbold">@lang('teacher.label_material_desc')</th>
            <th class="thbold">@lang('teacher.label_owner')</th>
            <th class="thbold">@lang('teacher.label_type')</th>
            <th class="thbold">@lang('teacher.materialformat')</th>
            <th class="thbold">@lang('teacher.label_date')</th>
            <th class="thbold">@lang('teacher.deleteoption')</th>
            </thead>
        </table>
        <div class="window-arrow">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="window-arrow-icon"><a href="javascript:void(0)"><i class="fa fa-chevron-left less" aria-hidden="true" style="display: none"></i><i class="fa fa-chevron-right more" aria-hidden="true"></i>
                    </a></div>
            <div class="more-material">
                <p>@lang('teacher.label_search_arrow')</p>
                <button type="submit" class="btn btn-material" id="download-materials-dashboard" data-url="{{generateLangugeUrl(App::getLocale(),url('/teacher/dashboard/downloadmaterials'))}}"><i class="material-icons">file_download</i><span class="btn-txt">@lang('teacher.label_download')</span></button>
                <div class="upload_material">
                    <button type="button" class="btn btn-material" id="btn_uploadMaterila"> <span class="text"><i class="material-icons">file_upload</i> @lang('adminmaterial.label_uploadmaterial')</span> </button>
                </div>
            </div>

        </div>
    </div>
    <div class="inner-modules-materials">
        @include("teacher.materialsmodel")
    </div>
</div>
