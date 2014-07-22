<?php namespace Strive\Admin\Controllers;

use \Auth;
use \Redirect;
use \View;
use \Input;
use \API;
use \Queue;
use \Request;
use \Session;
use \Carbon\Carbon;
use \User;
use \Job;
use \DB;
use Authority\Interfaces\AnalyticsInterface;
use \Sum;

class AnalyticsController extends \BaseController {
    public function __construct(AnalyticsInterface $analytics, Sum $sum){
        $this->analytics = $analytics;
        $this->sum = $sum;
    }
    public function index() {
        $unit = Input::get('unit','day');
        $numUnits = Input::get('numUnits',30);
        $daysInThePast = Carbon::today()->startOfWeek();
        switch($unit){
            case 'day': $daysInThePast = Carbon::now()->subDays($numUnits);break;
            case 'week': $daysInThePast = Carbon::today()->startOfWeek()->subDays(($numUnits-1)*7);break;
            case 'year': $daysInThePast = Carbon::now()->subDays($numUnits*365);break;
        }
        $userBreakdownForProcessing = $this->analytics->userBreakdown();
        $jobsForProcessing = $this->analytics->jobsByTime($unit,$daysInThePast);
        $salesForProcessing = $this->analytics->salesByTime($unit,$daysInThePast);
        $hitsForProcessing = $this->analytics->hitsByTime($unit,$daysInThePast);
        $signupsForProcessing = $this->analytics->signupsByTime($unit,$daysInThePast);
        $ratingsBreakdownForProcessing = $this->analytics->ratingsBreakdown($unit,$daysInThePast);
        $view['userBreakdown'] = $userBreakdownForProcessing;


        if($unit == 'day'){
            $view['jobs'] = $jobsForProcessing;
            $view['sales'] = $salesForProcessing;
            $view['hits'] = $hitsForProcessing;
            $view['signups'] = $signupsForProcessing;
            $view['ratingsBreakdown'] = $ratingsBreakdownForProcessing;
            $view['config'] = '';
        }
        elseif($unit == 'week'){
            $view['hits'] = $this->analytics->processToWeek($hitsForProcessing);
            $view['jobs'] = $this->analytics->processToWeek($jobsForProcessing);
            dd($salesForProcessing);
            #$view['sales'] = $salesForProcessing;
            $view['signups'] = $signupsForProcessing;
            $view['ratingsBreakdown'] = $ratingsBreakdownForProcessing;
            $view['config'] = [
                'minTickSize' => [
                    'value' => 3,
                    'size' => 'day'
                ]
            ];
        }

        $view['customScripts'] = [
            'plugins/flot/jquery.flot.js',
            'plugins/flot/excanvas.min.js',
            'plugins/flot/jquery.flot.tooltip.min.js',
            'plugins/flot/jquery.flot.resize.js',
            'plugins/flot/jquery.flot.pie.js',
            'plugins/flot/jquery.flot.axislabels.js',
            'plugins/flot/jquery.flot.orderBars.js',
            'plugins/flot/jquery.flot.time.js',
            'plugins/flot/jquery.flot.symbol.js',
            'plugins/flot/jshashtable-2.1.js',
            'plugins/flot/jquery.numberformatter-1.2.3.min.js',
            'plugins/flot/jquery.flot.stack.js'
        ];

        $view['title'] = 'Site Analytics';
        if(Input::has('pretty')){
            if(Input::get('pretty') == 'no'){
                $return = \Action::where('action','=','API query')->where('created_at', '>=',$daysInThePast)->groupBy('Year')->groupBy('week')->orderBy('week', 'DESC')->get([DB::raw('Year(created_at) as year'),DB::raw('Week(created_at) as week'), DB::raw('COUNT(*) as count')])->toArray();
                foreach($return as $key=>$val){
                    $return[$key]['time'] = strtotime(sprintf("%4dW%02d", $val['year'], $val['week']));
                }
                echo "<pre>";
                print_r($return);
                echo "</pre>";
            }
        }
        else{
            return  View::make('admin.pages.analyticsOverview', $view);
        }

    }
} 