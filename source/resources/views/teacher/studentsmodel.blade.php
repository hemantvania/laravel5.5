<div class="modal fade" id="add_edit_form" style="display: none;">
    <div class="modal-dialog">
        <form action="" method="post" id="student_from">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">@lang('teacher.addstudent')</h4>
                </div>
                <div id="form_data" class="modal-body">
                    {{ csrf_field() }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('general.close')</button>
                    <button type="button" class="btn btn-vdesk" id="savestudent">@lang('general.save')</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="assign_class" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">@lang('teacher.assign_student')</h4>
            </div>
            <div  class="modal-body">
                <p>@lang('teacher.assign_select_message')</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-vdesk" data-dismiss="modal">@lang('general.close')</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="assign_class_select_student" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">@lang('teacher.assign_student_select')</h4>
            </div>
            <div class="modal-body">
                <p>@lang('teacher.assign_student_select')</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-vdesk" data-dismiss="modal">@lang('general.close')</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
