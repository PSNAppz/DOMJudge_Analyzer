@extends('layouts.app')

@section('content')\
<div class="container">
    <div class="row">
        <div class="col-md-14 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading"><h3><i class="fa fa-bar-chart" aria-hidden="true"></i> Problem Summary</h3></div>
                <div class="panel-body">
                    <div class="page-header">
                        <h1>{{$prob->name}}  <small><span class="label label-primary"> {{$total}} Submissions</span></small></h1>
                    </div>

                    <h3>Summary</h3>

                    <h5>Time Limit: {{$prob->timelimit}}</h5>
                    <h5>Memory Limit: @if($prob->memlimit==NULL) No Limit @else{{$prob->memlimit}} @endif</h5>
                    <h5>Output Limit: @if($prob->outputlimit==NULL)No Limit @else{{$prob->outputlimit}}@endif</h5>
                    <h5>Special Run: {{$prob->special_run}}</h5>
                    <hr>
                    {!!$pie->render()!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
