<?php

namespace App\Http\Controllers;
use Charts;
use Illuminate\Http\Request;
use App\Submissions as Subs;
use DB;
use App\languages as lan;
use App\Judge;
use App\Problem;

class SubmissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function live(){
            $real=lan::where('langid','cpp')->get();
            $r=lan::count('langid','cpp');

            $results = DB::table('submission as a')
            ->select(['a.langid', DB::raw('count(*)')])
            ->join('language as b', 'a.langid', '=', 'b.langid')
            ->groupBy('b.langid')
            ->get();

            $summary=Subs::count();
            $correct=Judge::where('result','correct')->count();
            $compile=Judge::where('result','compiler-error')->count();
            $wrong=Judge::where('result','wrong-answer')->count();
            $timelimit=Judge::where('result','timelimit')->count();
            $run=Judge::where('result','run-error')->count();

            $chart2 = Charts::create('pie', 'fusioncharts')
            ->title('Submission Chart')
            ->labels(['Accepted', 'Compile Errors', 'Wrong Submissions','Time Limit Exceeded','Runtime Error'])
            ->values([$correct,$compile,$wrong,$timelimit,$run])
            ->dimensions(1000,500)
            ->responsive(false);

            $chart1 = Charts::database($results,'bar','plottablejs')
            ->title("")
            ->width(1000)
            ->elementLabel('Language Submissions')
            ->values($results->pluck('count(*)'))
            ->labels($results->pluck('langid'))
            ->responsive(false);

            $problems = Problem::get();

            return view('home')->withChart1($chart1)->withReal($real)->withSummary($summary)->withRun($run)
            ->withWrong($wrong)->withCompile($compile)->withCorrect($correct)->withTimelimit($timelimit)
            ->withChart2($chart2)->withProblems($problems);
        }
}
