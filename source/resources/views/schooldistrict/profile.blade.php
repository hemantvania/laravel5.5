@extends('layouts.vdesk')
@section("page-css")
@endsection
@section('content')
<section class="content-wrapper">
  <div class="container-fluid inner-contnet-wrapper">
    <div class="tab-wrapper">
      <div class="row">
        <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 user-details">@include("comman.discrict-nav") </div>
        @include("comman.navigation") </div>
    </div>

  </div>
</section>
<section class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
          <div class="scroll-main-wrapper2">
              @include('error.message')
             @include('layouts.user_profile')
          </div>
      </div>
  </div>
</section>
@endsection 