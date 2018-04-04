@extends('layouts.vdesk')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assests/admin/dist/css/portaladmin-dashboard.css') }}">

@endsection
<script>
    var colorsarr = [
        '#F2757B','#F79070','#FFCE2C','#C7D943', '#6DC0A7', '#00B4E3','#FDBE48'
    ];
    var userdata = new Array();
    var usercolors = new Array();

    var viewdata = new Array();
    var viewlabels = new Array();
    var viewcolors = new Array();

    var sharedata = new Array();
    var sharelabels = new Array();
    var sharecolors = new Array();

    var avglabels = new Array();
    var avgdata = new Array();
    var avgcolors = new Array();

    var schoolCount = new Array();
    var schoolColor = new Array();

</script>
@section('content')

@if(!empty($totalSchools))
    <script>
        schoolColor.push('#FDBE48');
        schoolCount.push('');
        schoolColor.push('#FDBE48');
        schoolCount.push({{$totalSchools}});
        schoolColor.push('#FDBE48');
        schoolCount.push('');
        schoolCount.push(0);
        idx = 0;
    </script>
@endif
@if(!empty($totalCount))

    @foreach($totalCount as $total)
        @if($total->userrole != 1 && $total->userrole != 5)
             <script>
                 userdata.push('{{$total->totalrecords}}');
                 usercolors.push(colorsarr[idx]);
                 idx++;
             </script>
        @endif
    @endforeach
    <script>
        userdata.push(0);
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

@if(!empty($avgTotal))
    @foreach($avgTotal as $total)
        <script> avglabels.push('{{$total->rolename}}');
                avgdata.push('{{$total->avgtime}}');
            avgcolors.push(colorsarr[idx]);
            idx++;

        </script>
    @endforeach
    <script>
        avgdata.push(0);
    </script>
@endif

<section class="content-wrapper">
          <div class="container-fluid inner-contnet-wrapper">
              <div class="tab-wrapper">
                  <div class="row">
                      <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 user-details">
                          @include("comman.admin-nav")
                      </div>
                      @include("comman.navigation")
                  </div>
              </div>
              <div class="row">
                  <div class="scroll-main-wrapper2">


                  <div class="col-sm-12">
                      <div class="">
                          &nbsp;
                      </div>
                  </div>

                       <div class="col-sm-12">
                         <div class="col-sm-4">
                             <div class="chart-bg">
                             <canvas id="bar-chart"></canvas>
                             </div>
                           </div>

                           <div class="col-md-4">
                               <div class="chart-bg">
                                <canvas id="schoolChart" class="schools"></canvas>
                               </div>
                           </div>

                           <div class="col-md-4">
                               <div class="chart-bg">
                               <canvas id="time-chart-avg-useractivity"></canvas>
                               </div>
                           </div>

                       </div>
                      <div class="col-sm-12">
                          <div style="height: 35px"></div>
                      </div>
                        <div class="col-sm-12">
                          <div class="col-md-4">
                              <div class="chart-bg">
                              <canvas id="bar-chart-material-view"></canvas>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <div class="chart-bg">
                              <canvas id="bar-chart-material-share"></canvas>
                              </div>
                          </div>
                            {{--<div class="col-md-4">
                                  <canvas id="pieChart"></canvas>
                              </div>--}}

                        </div>

              </div>
          </div>
      </section>
  @endsection

  @section('scripts')

      <script src="{{ asset('assests/admin/bower_components/Chart.js/Chart.js') }}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
      <script>

          new Chart(document.getElementById("schoolChart"), {
              type: 'bar',
              data: {
                  labels: ["", "Schools", ""],
                  datasets: [{
                      label: "Schools",
                      backgroundColor: schoolColor,
                      data: schoolCount
                  }]
              },
              options: {
                  legend: { display: false },
                  title: {
                      display: true,
                      text: 'Registered Schools'
                  }
              }
          });

          // Bar chart
          new Chart(document.getElementById("bar-chart"), {
              type: 'bar',
              data: {
                  labels: ["Teacher", "Student", "School District","School Admin"],
                  datasets: [
                      {
                          label: "Active",
                          backgroundColor: usercolors,
                          data: userdata
                      }
                  ]
              },
              options: {
                  legend: { display: false },
                  title: {
                      display: true,
                      text: 'Registered Users'
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


          // Time chart for avg user activity / avg time for login
          new Chart(document.getElementById("time-chart-avg-useractivity"), {
              type: 'bar',
              data: {
                  labels: avglabels,
                  datasets: [
                      {
                          label: "Activity",
                          backgroundColor: avgcolors,
                          data: avgdata
                      }
                  ]
              },
              options: {
                  legend: { display: false },
                  title: {
                      display: true,
                      text: 'Avg. Login In Minutes'
                  }
              }
          });
      </script>
  @endsection