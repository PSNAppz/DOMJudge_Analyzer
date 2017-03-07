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
                            {!! $chart2->render() !!}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="messages">
                            <h4>Total Solutions Submitted: {{$summary}}</h4>
                            <h4>Total Solutions Accepted: {{$correct}}</h4>
                            <h4>Compile Error: {{$compile}}</h4>
                            <h4>Time Limit Exceeded: {{$timelimit}}</h4>
                            <h4>Wrong Answer: {{$wrong}}</h4>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="settings">
                            N/A
                        </div>
                      </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-14 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading"><h3><i class="fa fa-bar-chart" aria-hidden="true"></i> Problem Summary</h3></div>
                <div class="panel-body">
                    <div class="list-group">
                        @foreach($problems as $p)
                      <a href="problem/{{$p->probid}}" class="list-group-item">
                        {{$p->name}}
                      </a>
                  @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
