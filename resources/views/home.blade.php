@extends('layouts.app')

@section('content')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<div class="container">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading"><h3><i class="fa fa-area-chart" aria-hidden="true"></i> Analytics Dashboard</h3></div>
                <div class="panel-body">
                    <div>
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Language Analytics</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Submission Graph</a></li>
                        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Submission Summary</a></li>
                        <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Problem Analysis</a></li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            {!! $chart1->render() !!}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            {!! $sub->render() !!}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="messages">
                            <h4>Total Solutions Submitted:21031</h4>
                            <h4>Total Solutions Accepted:124</h4>
                            <h4>Compile Error:1231</h4>
                            <h4>Memory Limit Exceeded:311</h4>
                            <h4>Wrong Answer:31031</h4>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="settings">
                            <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
                            <script src="https://code.highcharts.com/highcharts.js"></script>
                            <script src="https://code.highcharts.com/modules/exporting.js"></script>

                            <div id="container" style="min-width: 1000px; height: 400px; margin: 0 auto"></div>
                        </div>
                      </div>
                      <script>
                      $(document).ready(function () {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    Highcharts.chart('container', {
        chart: {
            type: 'spline',
            animation: Highcharts.svg, // don't animate in old IE
            marginRight: 10,
            events: {
                load: function () {

                    // set up the updating of the chart each second
                    var series = this.series[0];
                    setInterval(function () {
                        var x = (new Date()).getTime(), // current time
                            y = Math.random();
                        series.addPoint([x, y], true, true);
                    }, 5000);
                }
            }
        },
        title: {
            text: 'RealTime Submission'
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150
        },
        yAxis: {
            title: {
                text: 'Value'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                    Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
                    Highcharts.numberFormat(this.y, 2);
            }
        },
        legend: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        series: [{
            name: 'Random data',
            data: (function () {
                // generate an array of random data
                var data = [],
                    time = (new Date()).getTime(),
                    i;

                for (i = -19; i <= 0; i += 1) {
                    data.push({
                        x: time + i * 1000,
                        y:{!! json_encode($real->toArray()) !!}
                    });
                }
                return data;
            }())
        }]
    });
});
                      </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
