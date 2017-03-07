<?php
namespace App\Http\Controllers;

use Charts;
use Illuminate\Http\Request;
use App\Problem;
use App\Submissions as Sub;

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

        $pie = Charts::create('pie', 'fusioncharts')
        ->title('Submission Chart')
        ->labels(['C', 'CPP', 'Java','ADB','Ruby','Python'])
        ->values([$c,$cpp,$java,$adb,$rb,$py])
        ->dimensions(1000,500)
        ->responsive(false);

        return view('problem')->withProb($prob)->withPie($pie)->withTotal($total);
    }
}
