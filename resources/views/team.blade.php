@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading"><h3><i class="fa fa-bar-chart" aria-hidden="true"></i> Team Stats</h3></div>
                <div class="panel-body">
                    <div class="page-header">
                        <h1><i class="fa fa-user-circle-o" aria-hidden="true"></i> {{$team[0]->name}}  </h1><div class="well"><small>Submissions: <span class="label label-primary"> {{$total}}  </span> <br>Accuracy: <span class="label label-success"> {{$accuracy}} %</span></small></div>
                    </div>
                    

                    <h3><i class="fa fa-sticky-note" aria-hidden="true"></i> Summary</h3>
                    <div class="well">
                    <h5>Accepted Solutions: {{$correct}}</h5>

                    <h5>Wrong Submissions: {{$wrong}}</h5>

                    <h5>Compile Errors: {{$compile}}</h5>

                    <h5>Exceeded Time Limit: {{$time}}</h5>

                    <h5>Run Error: {{$run}}</h5>
                    </div>
                    <hr>
                    <h3><i class="fa fa-check-square-o" aria-hidden="true"></i> Solved Problems</h3>
                    
                    @if($solution != 0)
                    @foreach($solution as $sol)
                    {{$sol[0]->name}}<br>
                    @endforeach
                    @endif
                    <hr>
                    <h3><i class="fa fa-line-chart" aria-hidden="true"></i> Graph</h3>
                    {!! Chartist::renderCanvas('areaChart') !!}
                </div>
            </div>
        </div>
    </div>
</div>
{!! Chartist::renderScripts('areaChart') !!}
@endsection
