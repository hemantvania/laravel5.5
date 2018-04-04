<div class="modal fade" id="switch_class" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">@lang('teacher.switch_class_title')</h4>
            </div>
            <div  class="modal-body">
                <p>@lang('teacher.switch_class_sub_title')</p>
                <form id="start_class" name="start_class" method="post" action="{{ generateLangugeUrl(App::getLocale(),route('teacher.startClass')) }}" data-url="{{ generateLangugeUrl(App::getLocale(),route('teacher.checkOnlineStudentInClass')) }}">
                    {{ csrf_field() }}
                    <div class="btn-group" data-toggle="buttons">
                        @foreach($classes as $class)
                            <label class="btn btn-primary @if ($loop->first) active @endif">
                                <input type="radio" name="classoptions" data-time="{{ $class->class_duration }}" id="option_{{ $class->id}}" value="{{ $class->id}}" autocomplete="off" @if ($loop->first) checked @endif> {{ $class->className}}
                            </label>
                        @endforeach
                    </div>
                </form>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-vdesk" data-dismiss="modal">@lang('general.close')</button>
                <button type="button" class="btn btn-vdesk" id="btnstart">@lang('teacher.btn_start_class')</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>