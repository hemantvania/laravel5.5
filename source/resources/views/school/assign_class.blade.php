@extends('layouts.vdesk')
@section("page-css")
@endsection
@section('content')
    @include("error.message")
    <section class="content-wrapper">
        <div class="container-fluid inner-contnet-wrapper">
            <div class="tab-wrapper">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 user-details">
                        @include("comman.school-nav")
                    </div>
                    @include("comman.navigation")
                </div>
            </div>
            <div class="row">
                <div class="col-md-12"></div>
            </div>

        </div>
    </section>

    <section class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form role="form" action="{{ url('school/classes/assign-class') }} " method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>@lang('general.selectclass')<em>*</em></label>
                            <select class="form-control" name="class_id[]">
                                <option value="">@lang('general.selectclass')</option>
                                @if(!empty($classes))
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}">{{ $classe->className }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('class_id[0]'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('class_id[0]') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>@lang('general.selectteacher')<em>*</em></label>
                            <select class="form-control" name="user_id[]">
                                <option value="">@lang('general.selectteacher')</option>
                                @if(!empty($teachers))
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->userId }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('user_id[0]'))
                                <span class="help-block">
                                    <strong> {{ $errors->first('user_id[0]') }}</strong>
                                </span>
                            @endif
                        </div>
                            <button type="submit" name="submit" class="btn btn-vdesk">@lang('general.submit')</button>
                    </form>
               </div>
            </div>
        </div>
    </section>
@endsection
