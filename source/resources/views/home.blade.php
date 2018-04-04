@extends('layouts.vdesk')

@section('content')
    <section class="content-wrapper">
        <div class="container-fluid login-contnet-wrapper">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="login-section-title">@lang('student.title')  {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
                </div>
            </div>
        </div>
    </section>
@endsection
