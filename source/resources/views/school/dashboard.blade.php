
@extends('layouts.vdesk')

@section('content')
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
                <div class="col-sm-12">
                    <div id="myTabContent" class="tab-content scroll-main-wrapper2">
                        <div role="tabpanel" class="tab-pane fade in active" id="aineisto" aria-labelledby="aineisto-tab">
                            <div class="material-tab">
                                <div class="material-filter">
                                    <div class="">
                                       &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection