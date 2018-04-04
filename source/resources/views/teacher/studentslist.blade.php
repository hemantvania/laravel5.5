<div class="studentsmanagement-main">
    <div class="material-tab">
        <div class="material-filter">
            <div class="row">
                <ul class="clearfix">
                    <li class="search-filter col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="search-filter-main" id="adv-search">
                                    <input type="text" id="global_search_user" class="form-control select2" placeholder="@lang('teacher.label_s_search')" />
                                </div>
                            </div>
                        </div>
                    </li>
                    {{--25-10-17<li>
                        <a href="javascript:void(0);" data-url="{{ generateLangugeUrl( App::getLocale(),url('teacher/students/add'))}}" id="add_new" class="btn btn-vdesk custom-btn">@lang('teacher.addnewstudent')</a>
                    </li>--}}
                    <li class="share-filter col-lg-2 col-md-4 col-sm-6 col-xs-12">
                        <select class="selectpicker" id="studentclass" data-url="{{ generateLangugeUrl( App::getLocale(),url('/teacher/students/assign'))}} ">
                            <option value="0">@lang('teacher.assign_student')</option>
                            @foreach($classes as $class)
                                <option value="{{$class->id}}"> {{$class->className}}</option>
                            @endforeach
                        </select>
                    </li>
                </ul>
            </div>
        </div>
        <div class="materialtable">
            <table id="studentlist" width="100%" border="0" cellspacing="0" cellpadding="0" class="gridtable table-bordered">
                <thead>
                <th class="thbold" width="50px;">
                    <input name="select_all" value="1" id="student-select-all" type="checkbox">
                    <label for="student-select-all" id="studentselect"></label>
                </th>
                <th class="thbold">@lang('teacher.label_s_firstname')</th>
                <th class="thbold">@lang('teacher.label_s_lastname')</th>
                <th class="thbold">@lang('teacher.label_s_email')</th>
                <th class="thbold">@lang('teacher.label_s_phonenumber')</th>
                <th class="thbold">@lang('teacher.label_s_address')</th>   
				<th class="thbold">@lang('teacher.label_s_class')</th>
                {{--<th class="thbold">@lang('teacher.label_s_action')</th> 25-10-17 --}}
                </thead>
            </table>

        </div>
        <div class="inner-modules">
            @include("teacher.studentsmodel")
        </div>
    </div>
</div>

