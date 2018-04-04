@if(Session::has('message'))

    <div id="dynamic_display" class="alert-message media {{ Session::get('class') }}">
        <div class="media-left "><i class="material-icons">check_circle</i><!--i class="material-icons">swap_vertical_circle</i--></div>
        <div class="media-body" id="status_msg">{{ Session::get('message') }}</div>
        <div class="media-right"><a href="javascript:void(0);" id="close-btn-dynamic"><i class="material-icons">close</i></a></div>
    </div>
@endif
@if(Session::has('errors'))
    <div id="error_message_display" class="alert-message media active">
        <div class="media-left media-danger"><i class="material-icons">highlight_off</i></div>
        <div class="media-body" id="error_status_msg">@lang('general.failure')</div>
        <div class="media-right"><a href="javascript:void(0);" class="close-btn-danger" id="close-btn-danger"><i class="material-icons">close</i></a></div>
    </div>
@endif
