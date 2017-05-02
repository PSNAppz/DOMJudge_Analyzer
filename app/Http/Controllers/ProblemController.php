<?php
namespace App\Http\Controllers;

use Charts;
use Illuminate\Http\Request;
use App\Problem;
use DateTime;
use App\Submissions as Sub;
use App\Judging;
use DB;
use App\Judging as Judge;
use Khill\Lavacharts\Lavacharts;
use App\FuzzYLogic as FL;
use App\Team as Tm;
use Chartist;

class ProblemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($id){

        $prob =Problem::where('probid',$id)->first();
        $total =Sub::where('probid',$id)->count();
        
        $c= Sub::where('probid',$id)->where('langid','c')->count();
        $cpp=Sub::where('probid',$id)->where('langid','cpp')->count();
        $java=Sub::where('probid',$id)->where('langid','java')->count();
        $adb=Sub::where('probid',$id)->where('langid','adb')->count();
        $py=Sub::where('probid',$id)->where('langid','py')->count();
        $rb=Sub::where('probid',$id)->where('langid','rb')->count();

          $totalteams=Tm::count();
          $totans=FL::where('problem',$id)->count();

          if($totans/$totalteams >= 0.78125){
            $fuzz=1;
          }elseif($totans/$totalteams <=0.78124 && $totans/$totalteams>=0.626){
            $fuzz=2;
          }
          elseif($totans/$totalteams <= 0.625 && $totans/$totalteams>=0.3125){
            $fuzz=3;
          }
          elseif($totans/$totalteams<0.3125 &&$totans/$totalteams>0 ){
            $fuzz=4;
          }
          elseif($totans/$totalteams==0){
            $fuzz=5;
          }
          else{
            $fuzz=6;
          }
        $pie = Charts::create('pie', 'fusioncharts')
        ->title('Submission Chart')
        ->labels(['C', 'CPP', 'Java','ADB','Ruby','Python'])
        ->values([$c,$cpp,$java,$adb,$rb,$py])
        ->dimensions(1000,500)
        ->responsive(false);

        return view('problem')->withProb($prob)->withPie($pie)->withTotal($total)->withFuzz($fuzz);
    }

    public function teamAnalytics($id){
        $team=Tm::where('teamid',$id)->get();
        $total=Sub::where('teamid',$id)->count();
        $sol= $correct=DB::table('judging as a')
            ->select('*')
            ->where('result','correct')
            ->join('submission as b', 'a.submitid', '=', 'b.submitid')
            ->where('b.teamid',$id)
            ->get();
            $solution;$i=0;
            $Probname;
            $solution=NULL;
            foreach($sol as $s){
                $Probname=Sub::where('submitid',$s->submitid)->get();
                $solution[$i]=Problem::where('probid',$Probname[0]->probid)->get();
                $i++;
            }
       
           $correct=DB::table('judging as a')
            ->select('count(result)')
            ->where('result','correct')
            ->join('submission as b', 'a.submitid', '=', 'b.submitid')
            ->where('b.teamid',$id)
            ->count();
           $time=DB::table('judging as a')
            ->select('count(result)')
            ->where('result','timelimit')
            ->join('submission as b', 'a.submitid', '=', 'b.submitid')
            ->where('b.teamid',$id)
            ->count();
            $compile=DB::table('judging as a')
            ->select('count(result)')
            ->where('result','compiler-error')
            ->join('submission as b', 'a.submitid', '=', 'b.submitid')
            ->where('b.teamid',$id)
            ->count();
            $wrong=DB::table('judging as a')
            ->select('count(result)')
            ->where('result','wrong-answer')
            ->join('submission as b', 'a.submitid', '=', 'b.submitid')
            ->where('b.teamid',$id)
            ->count();
            $run=DB::table('judging as a')
            ->select('count(result)')
            ->where('result','run-error')
            ->join('submission as b', 'a.submitid', '=', 'b.submitid')
            ->where('b.teamid',$id)
            ->count();
            if($total !=0)
                $ac=$correct/($total)*100;
            else
                $ac=0;
            $accuracy=round($ac);

            $areaChart = Chartist::name('areaChart')
                        ->type('Line')
                        ->element('areaChart')
                        ->dimension(250)
                        ->labels(['Accepted', 'Wrong Ans', 'Run-error', 'Compile Error','Exceeded Time Limit'])
                        ->series([[
                            'label' => 'Accepted',
                            'fillColor' => 'rgba(210, 214, 222, 1)',
                            'strokeColor' => 'rgba(210, 214, 222, 1)',
                            'pointColor' => 'rgba(210, 214, 222, 1)',
                            'pointStrokeColor' => '#c1c7d1',
                            'pointHighlightFill' => '#fff',
                            'pointHighlightStroke' => 'rgba(220,220,220,1)',
                            'data' => [$correct,$wrong,$run,$compile,$time],
                        ]
                        ])->options([
                            'showScale' => true,
                            'scaleShowGridLines' => false,
                            'scaleGridLineColor' => 'rgba(0,0,0,.05)',
                            'scaleGridLineWidth' => 1,
                            'scaleShowHorizontalLines' => true,
                            'scaleShowVerticalLines' => true,
                            'bezierCurve' => true,
                            'bezierCurveTension' => 0.3,
                            'pointDot' => false,
                            'pointDotRadius' => 4,
                            'pointDotStrokeWidth' => 1,
                            'pointHitDetectionRadius' => 20,
                            'datasetStroke' => true,
                            'datasetStrokeWidth' => 21,
                            'datasetFill' => true,
                            'legendTemplate' => '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                            'maintainAspectRatio' => true,
                            'responsive' => true,
                        ]);

            return view('team')
            ->withTotal($total)
            ->withTeam($team)
            ->withCorrect($correct)
            ->withTime($time)
            ->withCompile($compile)
            ->withWrong($wrong)
            ->withRun($run)
            ->withAccuracy($accuracy)
            ->withSolution($solution);

    }

}
