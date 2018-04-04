<div class="pulpetit-main">
    <div class="material-filter">
        <div class="row">
            <ul class="clearfix">
                <li class="share-filter col-lg-2 col-md-4 col-sm-6 col-xs-12">
                    <select class="selectpicker" id="show_class" >
                        <option value="0">@lang('teacher.select_class_show')</option>
                        @foreach($classes as $class)
                            <option value="{{$class->id}}" data-url="{{ generateLangugeUrl( App::getLocale(),url('teacher/desk/').'/'.$class->id)}}"> {{$class->className}}</option>
                        @endforeach
                    </select>
                </li>
                <li>
                    <button class="btn btn-vdesk custom-btn btn-dropdown" id="btnshowdesk">@lang('teacher.showdesk')</button>
                </li>
            </ul>
        </div>
    </div>
    <div class="row" id="students-desk-list">

    </div>
</div>

