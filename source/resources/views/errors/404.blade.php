@extends('layouts.school')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1>@lang('404.label_title')</h1>
                    <h2>@lang('404.label_sub_title')</h2>
                    <div class="error-details">
                        @lang('404.label_text')
                    </div>
                    <div class="error-actions">


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection