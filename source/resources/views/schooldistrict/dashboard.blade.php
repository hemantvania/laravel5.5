@extends('layouts.vdesk')


<script>
    var colorsarr = [
        '#F2757B','#F79070','#FFCE2C','#C7D943', '#6DC0A7', '#00B4E3','#FDBE48'
    ];
    var schoollabels = new Array();
    var schooldata = new Array();
    var schoolcolors = new Array();

    var sharedata = new Array();
    var sharelabels = new Array();
    var sharecolors = new Array();

    var viewdata = new Array();
    var viewlabels = new Array();
    var viewcolors = new Array();

    var userdata = new Array();
    var usercolors = new Array();
    idx = 0;
</script>

@section('content')
    @if(!empty($totalUser))
        @foreach($totalUser as $total)
            @if($total->userrole != 1)
                <script>
                schoollabels.push('{{$total->schoolName}}');
                schooldata.push('{{$total->totalrecords}}');
                schoolcolors.push(colorsarr[idx]);
                idx++;
                </script>
            @endif
        @endforeach
        <script>
            schooldata.push(0);
            var idx = 0;
        </script>
    @endif
    @if(!empty($totalView))
        @foreach($totalView as $total)
            <script>
                viewlabels.push('{{$total->materialType}}');
                viewdata.push('{{$total->totalrecords}}');
                viewcolors.push(colorsarr[idx]);
                idx++;
            </script>
        @endforeach
        <script>
            viewdata.push(0);
            var idx = 0;
        </script>
    @endif

    @if(!empty($totalShare))
        @foreach($totalShare as $total)
            <script>
                sharelabels.push('{{$total->materialType}}');
                sharedata.push('{{$total->totalrecords}}');
                sharecolors.push(colorsarr[idx]);
                idx++;
            </script>
        @endforeach
        <script>
            sharedata.push(0);
            var idx = 0;
        </script>
    @endif

    <section class="content-wrapper">
        <div class="container-fluid inner-contnet-wrapper">
            <div class="tab-wrapper">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 user-details">
                        @include("comman.discrict-nav")
                    </div>
                    @include("comman.navigation")
                </div>
            </div>
            <div class="row">
                <div class="scroll-main-wrapper3    ">
                <div class="col-sm-12">
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="aineisto" aria-labelledby="aineisto-tab">
                            <div class="material-tab">
                                <div class="material-filter">
                                    <div class="" >
                                      &nbsp;
                                    </div>
                                </div>
                                <div class="materialtable">

                                    <div class="col-sm-12">

                                        <div class="col-sm-4 ">
                                            <div class="chart-bg">
                                                <canvas id="bar-chart-school-district"></canvas>
                                            </div>
                                         </div>
                                         <div class="col-md-4 ">
                                             <div class="chart-bg">
                                             <canvas id="bar-chart-material-view"></canvas>
                                             </div>
                                         </div>
                                         <div class="col-md-4 ">
                                             <div class="chart-bg">
                                             <canvas id="bar-chart-material-share"></canvas>
                                             </div>
                                         </div>

                                     </div>
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

@section('scripts')

    <script src="{{ asset('assests/admin/bower_components/Chart.js/Chart.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
    <script>


        // Bar chart
        new Chart(document.getElementById("bar-chart-school-district"), {
            type: 'bar',
            data: {
                labels: ["Teacher", "Student", "School Admin"],
                datasets: [
                    {
                        label: "Active",
                        backgroundColor: schoolcolors,
                        data: schooldata
                    }
                ]
            },
            options: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Registered Users in Schools'
                }
            }
        });




        // Bar chart for view material
        new Chart(document.getElementById("bar-chart-material-view"), {
            type: 'bar',
            data: {
                labels: viewlabels,
                datasets: [
                    {
                        label: "View",
                        backgroundColor: viewcolors,
                        data: viewdata
                    }
                ]
            },
            options: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Viewed Material'
                }
            }
        });

        // Bar chart for share material
        new Chart(document.getElementById("bar-chart-material-share"), {
            type: 'bar',
            data: {
                labels: sharelabels,
                datasets: [
                    {
                        label: "Share",
                        backgroundColor: sharecolors,
                        data: sharedata
                    }
                ]
            },
            options: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Shared Material'
                }
            }
        });

    </script>
@endsection