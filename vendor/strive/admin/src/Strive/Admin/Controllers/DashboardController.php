<?php namespace Strive\Admin\Controllers;

use \Auth;
use \Action;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use \Restable;
use \View;
use \User;
use \DB;
use \Transaction;
use \Input;
use \Job;
use \Charge;
use \Redirect;
use Authority\Interfaces\AnalyticsInterface;
use \Sum;
use \Rating;


class DashboardController extends BaseController {
    public function __construct(AnalyticsInterface $analytics, Sum $sum){
        $this->analytics = $analytics;
        $this->sum = $sum;
    }
    public function index() {
        $monthStart = Carbon::today()->startOfMonth()->toDateString();
        $query = 10;
        $view['title'] = 'Dashboard';
        $unit = Input::get('unit','day');
        $numUnits = Input::get('numUnits',30);
        $mtdStats = $this->analytics->mtdStats();

        switch($unit){
            case 'day': $daysInThePast = Carbon::today()->subDays($numUnits);$minTickSize=1;break;
            case 'week': $daysInThePast = Carbon::today()->startOfWeek()->subWeeks($numUnits-1);$minTickSize=7;break;
            case 'month': $daysInThePast = Carbon::today()->firstOfMonth()->subMonths($numUnits);$minTickSize=30;break;
            case 'year': $daysInThePast = Carbon::now()->subDays($numUnits*365);break;
        }

        $view = [
            'usersMTD' => $mtdStats['usersMTD'],
            'salesMTD' => $mtdStats['salesMTD'],
            'contractorsMTD' => $mtdStats['contractorsMTD'],
            'employersMTD' => $mtdStats['employersMTD'],
            'hitsMTD' => $mtdStats['hitsMTD'],
            'newJobsMTD' => $mtdStats['newJobsMTD'],
            'jobs' => $this->analytics->jobsByTime($unit,$daysInThePast),
            'sales' => $this->analytics->salesByTime($unit,$daysInThePast),
            'hits' => $this->analytics->hitsByTime($unit,$daysInThePast),
            'signups' => $this->analytics->signupsByTime($unit,$daysInThePast),
            'ratingsBreakdown' => $this->analytics->ratingsBreakdown($unit,$daysInThePast),
            'userBreakdown' => $this->analytics->userBreakdown(),
            'minTickSize' => ['value' => $minTickSize,
                'size' => 'day'],
            'title' => 'Site Analytics'
        ];

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

        if(Input::has('pretty')){

            echo "<pre>";
            print_r($view);
            echo "</pre>";
        }
        else{
            return View::make('admin.pages.dashboard', $view);
        }

    }
} 