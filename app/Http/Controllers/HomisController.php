<?php

namespace App\Http\Controllers;

use App\Homis\Erlog;
use App\Homis\Opdlog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomisController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    static function getErLog($date,$shift)
    {
        $date = date('Y-m-d',strtotime($date));
        if($shift==1){
            $start = "$date 06:00:00";
            $end = "$date 14:00:00";
        }else if($shift==2){
            $start = "$date 14:00:00";
            $end = "$date 22:00:00";
        }else if($shift==3){
            $start = "$date 22:00:00";
            $tmp = Carbon::parse($date)->addDay(1);
            $tmp = date('Y-m-d',strtotime($tmp));
            $end = "$tmp 06:00:00";
        }else{
            $start = Carbon::parse($date)->startOfDay();
            $end = Carbon::parse($date)->endOfDay();
        }

        $count = Erlog::select('herlog.hpercode','hperson.patfirst','hperson.patlast','herlog.erdate')
                    ->leftJoin('hperson','hperson.hpercode','=','herlog.hpercode')
                    ->whereBetween('erdate',[$start,$end])
                    ->count();
        return $count;
    }

    static function getOpdLog($date,$shift)
    {
        $date = date('Y-m-d',strtotime($date));
        if($shift==1){
            $start = "$date 06:00:00";
            $end = "$date 14:00:00";
        }else if($shift==2){
            $start = "$date 14:00:00";
            $end = "$date 22:00:00";
        }else if($shift==3){
            $start = "$date 22:00:00";
            $tmp = Carbon::parse($date)->addDay(1);
            $tmp = date('Y-m-d',strtotime($tmp));
            $end = "$tmp 06:00:00";
        }else{
            $start = Carbon::parse($date)->startOfDay();
            $end = Carbon::parse($date)->endOfDay();
        }

        $count = Opdlog::whereBetween('opddate',[$start,$end])
                    ->count();
        return $count;
    }

    public function patientLog()
    {
        $data = array();
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $shift = 1;

        if(Session::get('log_start_date'))
        {
            $start = Carbon::parse(Session::get('log_start_date'))->startOfMonth();
            $end = Carbon::parse(Session::get('log_end_date'))->endOfMonth();
        }

        if(Session::get('log_shift'))
            $shift = Session::get('log_shift');

        do {
            $data[] = $start;

            $start = Carbon::parse($start)->addDay(1);
        }while($start <= $end);

        return view('homis.patientLog',[
            'title' => 'Patient Log',
            'menu' => 'patientLog',
            'shift' => $shift,
            'data' => $data,
            'month' => Carbon::parse($end)->format('F'),
            'year' => Carbon::parse($end)->format('Y')
        ]);
    }

    public function filterErLog(Request $req)
    {
        $tmp = "$req->year-$req->month-01";
        Session::put('log_start_date',Carbon::parse($tmp)->startOfMonth());
        Session::put('log_end_date',Carbon::parse($tmp)->endOfMonth());
        Session::put('log_shift',$req->shift);
        Session::put('log_month',$req->month);
        Session::put('log_year',$req->year);

        print_r($_POST);
        return redirect('patient/logs');
    }
}
