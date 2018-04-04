<div class="material-tab">
    <div class="material-filter">
         <div>
             @if(count($userClass)> 0 )
              <button type="button" name="im_done" id="imDone" data-class-id="{{$userClass->class_id}}" class="btn btn-vdesk ">@lang('student.i_m_done_for_class') - {{$userClass->studentClass->className }}</button>
             @else
                 <div class="chart-bg error-message">@lang('student.not_class_assigned')</div>
             @endif
         </div>
    </div>
    <div class="student-materialtable">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="gridtable-student table-bordered">
            <thead>
            <th class="thbold">@lang('student.label_material_name')</th>
            <th class="thbold">@lang('student.label_type')</th>
            </thead>
            <tbody>
            @forelse ($matirialsList as $material)
                <tr>
                    <td data-label="material_name">
                        <a class="material-listing" href="{{ $material->link }}" material-id="{{ $material->id }}" class-id="{{$userClass->class_id}}">{{ $material->materialName }}</a></td>
                    <td data-label="type">{{ $material->materialType }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">@lang('general.norecords')</td>
                </tr>
            @endforelse
           </tbody>
        </table>
        @if(Auth::user()->userrole === 2)
            <div class="window-arrow">
                <div class="window-arrow-icon"><a href="#"><i class="material-icons more">keyboard_arrow_right</i><i class="material-icons less" style="display: none">keyboard_arrow_left</i></a></div>
                <div class="more-material">
                    <p>Voit hakea lisää aineistoa oppitunnille.</p>
                    <button type="submit" class="btn btn-material"><i class="material-icons">file_download</i><span class="btn-txt">LATAA AINEISTOA</span></button>
                </div>
            </div>
        @endif
    </div>

</div>