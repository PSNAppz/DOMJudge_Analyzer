<?php

namespace App\Http\Controllers;
use Charts;
use Illuminate\Http\Request;
use App\Submissions as Subs;
use DB;
use App\languages as lan;
class SubmissionController extends Controller
{
    public function showGraph(){

    }
    
    public function live(){
        $real=lan::where('langid','cpp')->get();
        $r=lan::count('langid','cpp');

        $sub= Charts::multi('areaspline', 'highcharts')
        ->title('')
        ->width(1000)
        ->colors(['#ff0000', '#ffffff'])
        ->labels(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday', 'Sunday'])
        ->dataset('Accepted', [3, 4, 3, 5, 4, 10, 12])
        ->dataset('Wrong',  [1, 3, 4, 3, 3, 5, 4]);

        $results = DB::table('submission as a')
  ->select(['a.langid', DB::raw('count(*)')])
  ->join('language as b', 'a.langid', '=', 'b.langid')
  ->groupBy('a.langid')
  ->get();

        $chart1 = Charts::database($results,'bar')
                    ->title("")
                    ->width(1000)
            ->elementLabel('Language Submissions')
            ->values($results->pluck('count(*)'))
            ->labels($results->pluck('langid'))
            ->responsive(false);
            return view('home')->withSub($sub)->withChart1($chart1)->withReal($real);
        }
}
