<?php  namespace Authority\Repositories;

use Carbon\Carbon;
use Authority\Interfaces\AnalyticsInterface;
use \User;
use \Charge;
use \Rating;
use \Action;
use \Job;
use \Group;
use \DB;
use \Sum;


class AnalyticsRepository implements AnalyticsInterface {

    public function __construct() {
    }
    public function ratingsBreakdown($unit, $daysInThePast, $rating = null) {
        if($unit == 'day'){
            $ratings = Rating::where('created_at', '>=', $daysInThePast)->groupBy('time')->orderBy('time', 'DESC')->get([DB::raw('UNIX_TIMESTAMP(Date(created_at))*1000 as time'), DB::raw('AVG(rating) as average')])->toArray();
        }
        elseif($unit == 'week'){
            $ratings = Rating::where('created_at', '>=', $daysInThePast)->groupBy('week')->groupBy('year')->orderBy('week', 'DESC')->get([DB::raw('Year(created_at) as year'), DB::raw('Week(created_at) as week'), DB::raw('AVG(rating) as average')])->toArray();
        }
        elseif($unit == 'month'){
            $ratings = Rating::where('created_at', '>=', $daysInThePast)->groupBy('month')->groupBy('year')->orderBy('month', 'DESC')->get([DB::raw('Year(created_at) as year'), DB::raw('Month(created_at) as month'), DB::raw('AVG(rating) as average')])->toArray();
        }
        foreach($ratings AS $r){
            switch($unit) {
                case 'day': $date = $r['time'];break;
                case 'week': $date = strtotime(sprintf("%4dW%02d", $r['year'], $r['week']))*1000;break;
                case 'month': $date = strtotime($r['year']."-".$r['month']."-01")*1000;break;
            }
            $return[] = ['time' => $date, 'average'=>round($r['average'],1)];
        };

        return $return;
    }

    public function salesByTime($unit, $daysInThePast) {
        if($unit == 'day'){
            $return = Charge::where('created_at', '>=', $daysInThePast)->groupBy('time')->orderBy('time', 'DESC')->get([DB::raw('UNIX_TIMESTAMP(Date(created_at))*1000 as time'), DB::raw('sum(amount) as sum')])->toArray();
        } elseif ($unit == 'week') {
            $result = Charge::where('created_at', '>=', $daysInThePast)->groupBy('week')->groupBy('year')->orderBy('week', 'DESC')->get([DB::raw('Year(created_at) as year'), DB::raw('Week(created_at) as week'), DB::raw('sum(amount) as sum')])->toArray();
            $return = $this->processToWeek($result,'sum');
        }
        elseif($unit == 'month'){
            $result = Charge::where('created_at', '>=', $daysInThePast)->groupBy('month')->groupBy('year')->orderBy('month', 'DESC')->get([DB::raw('Year(created_at) as year'), DB::raw('Month(created_at) as month'), DB::raw('sum(amount) as sum')])->toArray();
            $return = $this->processToMonth($result,'sum');
        }

        return $return;
    }

    public function jobsByTime($unit, $daysInThePast) {
        if ($unit == 'day') {
            $return = Job::where('created_at', '>=', $daysInThePast)->groupBy('time')->orderBy('time', 'DESC')->get([DB::raw('UNIX_TIMESTAMP(Date(created_at))*1000 as time'), DB::raw('COUNT(*) as count')])->toArray();
        } elseif ($unit == 'week') {
            $result = Job::where('created_at', '>=', $daysInThePast)->groupBy('week')->groupBy('year')->orderBy('week', 'DESC')->get([DB::raw('Year(created_at) as year'), DB::raw('Week(created_at) as week'), DB::raw('COUNT(*) as count')])->toArray();
            $return = $this->processToWeek($result);
        }
        elseif($unit == 'month'){
            $result = Job::where('created_at', '>=', $daysInThePast)->groupBy('month')->groupBy('year')->orderBy('month', 'DESC')->get([DB::raw('Year(created_at) as year'), DB::raw('Month(created_at) as month'), DB::raw('COUNT(*) as count')])->toArray();
            $return = $this->processToMonth($result);
        }
        return $return;
    }

    public function hitsByTime($unit, $daysInThePast) {
        if ($unit == 'day') {
            $return = Action::where('action', '=', 'API query')->where('created_at', '>=', $daysInThePast)->groupBy('time')->orderBy('time', 'DESC')->get([DB::raw('UNIX_TIMESTAMP(Date(created_at))*1000 as time'), DB::raw('COUNT(*) as count')])->toArray();
        } elseif ($unit == 'week') {
            $result = Action::where('action', '=', 'API query')->where('created_at', '>=', $daysInThePast)->groupBy('week')->groupBy('year')->orderBy('week', 'DESC')->get([DB::raw('Year(created_at) as year'), DB::raw('Week(created_at) as week'), DB::raw('COUNT(*) as count')])->toArray();
            $return = $this->processToWeek($result);
        }
        elseif($unit == 'month'){
            $result = Action::where('action', '=', 'API query')->where('created_at', '>=', $daysInThePast)->groupBy('month')->groupBy('year')->orderBy('month', 'DESC')->get([DB::raw('Year(created_at) as year'), DB::raw('Month(created_at) as month'), DB::raw('COUNT(*) as count')])->toArray();
            $return = $this->processToMonth($result);
        }
        return $return;
    }

    public function userBreakdown() {
        $totalUsers = User::count();
        $employers = User::whereHas('groups', function ($query) {
                $query->where('name', '=', 'Employers');
            })->count();
        $contractors = User::whereHas('groups', function ($query) {
                $query->where('name', '=', 'Contractors');
            })->count();
        $employees = $totalUsers - $employers - $contractors;
        return ['employers' => $employers, 'employees' => $employees, 'contractors' => $contractors];
    }

    public function signupsByTime($unit, $daysInThePast) {
        if ($unit == 'day') {
            $return = User::where('created_at', '>=', $daysInThePast)->groupBy('time')->orderBy('time', 'DESC')->get([DB::raw('UNIX_TIMESTAMP(Date(created_at))*1000 as time'), DB::raw('COUNT(*) as count')])->toArray();
        } elseif ($unit == 'week') {
            $result = User::where('created_at', '>=', $daysInThePast)->groupBy('week')->groupBy('year')->orderBy('week', 'DESC')->get([DB::raw('Year(created_at) as year'), DB::raw('Week(created_at) as week'), DB::raw('COUNT(*) as count')])->toArray();
            $return = $this->processToWeek($result);
        }
        elseif($unit == 'month'){
            $result = User::where('created_at', '>=', $daysInThePast)->groupBy('month')->groupBy('year')->orderBy('month', 'DESC')->get([DB::raw('Year(created_at) as year'), DB::raw('Month(created_at) as month'), DB::raw('COUNT(*) as count')])->toArray();
            $return = $this->processToMonth($result);
        }
        return $return;
    }

    public function processToWeek($days,$columnName = 'count'){
        sort($days);
        $return = [];
        foreach($days as $day){
            $return[] = ['time' => strtotime(sprintf("%4dW%02d", $day['year'], $day['week']))*1000,$columnName=>$day[$columnName]];
        }
        return $return;
    }
    public function processToMonth($days,$columnName = 'count'){
        sort($days);
        $return = [];
        foreach($days as $day){
            $return[] = ['time' => strtotime(Carbon::createFromFormat("Y-m",$day['year']."-".$day['month'])->toDateTimeString())*1000,$columnName=>$day[$columnName]];
        }
        return $return;
    }

    public function groupRatingsByWeek($ratings){
        $runningTotal = 0;
        $return = [];
        $i = 0;
        foreach($ratings as $day){
            if($i==0){
                $runningTotal = 0;
                $time = $day['time'];
            }
            $runningTotal = $runningTotal + $day['count'];
            $i = $i+1;
            if($i == 7){
                $i = 0;
                $return[] = ['time' => $time, 'count' => $runningTotal];
            }
        }
        return $return;
    }

    public function mtdStats(){
        $monthStart = Carbon::today()->startOfMonth()->toDateString();
        return [
            'usersMTD' => $this->usersMTD($monthStart),
            'salesMTD' => $this->salesMTD($monthStart),
            'contractorsMTD' => $this->contractorsMTD($monthStart),
            'employersMTD' => $this->employersMTD($monthStart),
            'hitsMTD' => $this->jobsMTD($monthStart),
            'newJobsMTD' => $this->hitsMTD($monthStart)
        ];
    }
    public function usersMTD($monthStart){
        return User::where('created_at', '>=', $monthStart)->count();
    }
    public function salesMTD($monthStart){
        return Charge::where('created_at', '>=', $monthStart)->sum('amount');
    }
    public function contractorsMTD($monthStart){
        return User::whereHas('groups',function($q){$q->where('groups.id','=','3');})->get()->count();
    }
    public function employersMTD($monthStart){
        return User::whereHas('groups',function($q){$q->where('groups.id','=','4');})->get()->count();
    }
    public function jobsMTD($monthStart){
        return Job::where('created_at', '>=', $monthStart)->count();
    }
    public function hitsMTD($monthStart){
        return Action::where('created_at', '>=', $monthStart)->count();
    }
}