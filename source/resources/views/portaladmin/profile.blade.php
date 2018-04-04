@extends('layouts.vdesk')
@section("page-css")
@endsection
@section('content')
    @include("error.message")
    <section class="content-wrapper">
        <div class="container-fluid inner-contnet-wrapper">
            <div class="tab-wrapper">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 user-details">@include("comman.admin-nav")</div>
                    @include("comman.navigation")
                 </div>
            </div>

        </div>
    </section>
    <section class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="scroll-main-wrapper2">
                       @include('layouts.user_profile')
                    </div>
                </div>
            </div>
    </section>
@endsection
@section('scripts')

@endsection