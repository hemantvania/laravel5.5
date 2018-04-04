<!-- Modal -->
<div class="modal fade" id="incomingScreenShare" tabindex="-1" role="dialog" aria-labelledby="incomingScreenShareModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="incomingScreenShareModalLabel"></span>@lang('teacher.incomingShareTitle')<span id="requestedByName"></h5>
            </div>
            <div class="modal-body">
                @lang('teacher.incomingShareMessage')
            </div>
            <div class="modal-footer">
                    <button type="button" id="reject_incoming_share_request" class="btn default">@lang('student.btnlink_reject')</button>
                    <button type="button" id="btnviewscreen" class="btn btn-primary">@lang('student.btnopenlink')</button>
            </div>
        </div>
    </div>
</div>