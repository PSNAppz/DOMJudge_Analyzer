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
                        <li role="presentation" ><a href="#team" aria-controls="team" role="tab" data-toggle="tab">Team Analytics</a></li>
                        
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Submission Graph</a></li>
                        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Submission Summary</a></li>
                        <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Problem Analysis</a></li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="home">
                            {!! $chart1->render() !!}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="team">
                            <div class="list-group">
                            <br>
                            @foreach($teamnames as $tmn)
                              <a href="/team/{{$tmn->teamid}}" class="list-group-item list-group-item-success">{{$tmn->name}}</a>
                              @endforeach
                            </div>                           </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            {!! $chart2->render() !!}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="messages">
                        <div class="well well-lg">
                        <center>
                            <table>
                            <tr><td><h4>Total Solutions Submitted:&nbsp;&nbsp;&nbsp; </td><td><span class="label label-primary">{{$summary}}</span></td></h4></tr>
                           <tr><td><h4>Total Solutions Accepted: </td><td><span class="label label-success">{{$correct}}</span></td></h4></tr>
                            <tr><td><h4>Compile Error: </td><td><span class="label label-warning">{{$compile}}</span></td></h4></tr>
                            <tr><td><h4>Time Limit Exceeded: </td><td><span class="label label-info">{{$timelimit}}</span></td></h4></tr>
                           <tr><td><h4>Wrong Answer: </td><td><span class="label label-danger">{{$wrong}}</span></td></h4></tr>
                            </table>
                            </center>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="settings">
                            <h2>TOP 5 Solved Problems</h2>
                            <ul class="list-group">
                            @foreach($top as $key => $t)
                              <li class="list-group-item"> {{$t[0]->name}}               
                               <span class="badge">{{$count[$key]}} </span>
                            </li>
                            @endforeach
                            </ul>
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
