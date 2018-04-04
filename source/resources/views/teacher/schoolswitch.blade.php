@extends('layouts.school')
@section("page-css")

@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1> @lang('switch.label_title')</h1>
                    <div class="error-details">
                        @lang('switch.label_subtext')
                    </div>
                    <div class="error-actions">
                        <form name="switch_school" method="post" action="{{ generateLangugeUrl(App::getLocale(),route('teacher.schoolwsitchsubmit')) }}">
                            {{ csrf_field() }}
                            <div class="btn-group" data-toggle="buttons">
                                @foreach($schools as $school)
                                    @if($session_school!='')
                                        <label class="btn btn-multi-school @if($session_school == $school->school_id) active @endif">
                                            <input type="radio" name="schooloptions" id="option_{{$school->school_id}}" value="{{$school->school_id}}" autocomplete="off"> {{$school->schoolName}}
                                        </label>
                                        @else
                                        <!--label class="btn btn-primary @if($loop->first) active @endif"-->
                                        <label class="btn btn-multi-school @if(!empty(Auth::user()->userMeta->default_school) && Auth::user()->userMeta->default_school == $school->school_id ) active @endif">
                                            <input type="radio" name="schooloptions" id="option_{{$school->school_id}}" value="{{$school->school_id}}" autocomplete="off"> {{$school->schoolName}}
                                        </label>
                                    @endif

                                @endforeach
                            </div>
                            <br />
                            <br />
                            <br />
                            <button type="submit" class="btn btn-vdesk" name="btn_switch" id="btn_switch"> @lang('switch.label_btn')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection