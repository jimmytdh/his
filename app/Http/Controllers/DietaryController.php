<?php

namespace App\Http\Controllers;

use App\Bmi;
use App\Diet;
use App\Homis\Admlog;
use App\Homis\Room;
use App\Homis\Ward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DietaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    public function index()
    {
        return view('modules.dietary.index',[
            'title' => 'Dietary Module',
            'menu' => 'home',
            'menu_module' => 'menu.dietary'
        ]);
    }

    public function patientList()
    {
        $keyword = Session::get('search_dietary_keyword');
        $ward = Session::get('search_dietary_ward');
        $with = Session::get('search_dietary_with');

        $data = Admlog::orderBy('patlast','asc')
                    ->leftJoin('hperson','hperson.hpercode','=','hadmlog.hpercode')
                    ->select(
                        'hperson.hpercode as code',
                        'hperson.patfirst as fname',
                        'hperson.patlast as lname',
                        'hperson.patmiddle as mname',
                        'hadmlog.patage as age',
                        'hperson.patsex as sex',
                        'hadmlog.admdate as date_admitted'
                    );

        if($keyword){
            $data = $data->where(function($q) use($keyword){
                $q->orwhere('hperson.patfirst','like',"%$keyword%")
                    ->orwhere('hperson.patlast','like',"%$keyword%")
                    ->orwhere('hperson.patmiddle','like',"%$keyword%")
                    ->orwhere('hperson.hpercode','like',"%$keyword%");
                });
        }

        if($ward){
            $data = $data->leftJoin('hpatroom','hpatroom.hpercode','=','hadmlog.hpercode')
                    ->where('hpatroom.wardcode',$ward)
                    ->groupBy('hpatroom.hpercode');
        }

        if($with){
            $diet = Diet::select('code')->where('date_added',date('Y-m-d'))->get();
            if($with=='with'){
                $data = $data->whereIn('hadmlog.hpercode',$diet);
            }elseif($with=='without'){
                $data = $data->whereNotIn('hadmlog.hpercode',$diet);
            }
        }


        $data = $data->where('hadmlog.disdate',null)
                    ->paginate(20);

        $wards = Ward::orderBy('wardname','asc')->get();


        return view('modules.dietary.list',[
            'title' => 'Patient List',
            'menu' => 'patients',
            'menu_module' => 'menu.dietary',
            'data' => $data,
            'wards' => $wards
        ]);
    }

    public function discharged(){
        $keyword = Session::get('search_dietary_discharged_keyword');

        $data = Admlog::orderBy('disdate','desc')
            ->leftJoin('hperson','hperson.hpercode','=','hadmlog.hpercode')
            ->select(
                'hperson.hpercode as code',
                'hperson.patfirst as fname',
                'hperson.patlast as lname',
                'hperson.patmiddle as mname',
                'hadmlog.patage as age',
                'hperson.patsex as sex',
                'hadmlog.admdate as date_admitted',
                'hadmlog.disdate as date_discharged'
            );

        if($keyword){
            $data = $data->where(function($q) use($keyword){
                $q->orwhere('hperson.patfirst','like',"%$keyword%")
                    ->orwhere('hperson.patlast','like',"%$keyword%")
                    ->orwhere('hperson.patmiddle','like',"%$keyword%")
                    ->orwhere('hperson.hpercode','like',"%$keyword%");
            });
        }
        $start = Carbon::now()->startOfDay();
        $end = Carbon::now()->endOfDay();

        $data = $data->whereBetween('hadmlog.disdate',[$start,$end])
            ->paginate(20);

        return view('modules.dietary.discharged',[
            'title' => 'Discharged Patients',
            'menu' => 'discharged',
            'menu_module' => 'menu.dietary',
            'data' => $data
        ]);
    }

    public function searchList(Request $req)
    {
        Session::put('search_dietary_keyword',$req->keyword);
        Session::put('search_dietary_ward',$req->ward);
        Session::put('search_dietary_with',$req->with);
        return redirect('dietary/patients');
    }

    static function diet($code)
    {
        switch($code){
            case 'DAT':
                return 'Diet as Tolerated';
            case 'FTW':
                return 'Food to Watcher';
            case 'HI FIBER':
                return 'High FIBER';
            case 'NDCF':
                return 'No Dark Color Foods';
            case 'SOFT':
                return 'Soft Diet';
            case 'HYPO':
                return 'Hypoallergenic';
            case 'HYPO NDCF':
                return 'Hypoallergenic, No Dark Color Foods';
            case 'DIABETIC':
                return 'Diabetic';
            case 'LO SALT LO FAT':
                return 'Low Salt Low Fat';
            case 'HYPO LO SAL LO FAT':
                return 'Hypoallergenic Low Salt Low Fat';
            case 'UREMIC':
                return 'Uremic Diet';
            case 'LO POTASSIUM':
                return 'Low Potassium';
            case 'LO PURINE':
                return 'Low Purine';
            case 'LO OXALATE':
                return 'Low Oxalate';
            case 'LIQUID DIET':
                return 'Liquid Diet';
            case 'BLENDERIZE FEEDING':
                return 'Blenderize Feeding';
            default:
                return 'N/A';
        }
    }

    public function loadDiet($code)
    {
        $height = 0;
        $weight = 0;
        $diet_code = '';
        $remarks = '';

        $bmi = Bmi::where('code',$code)->first();
        $diet = Diet::where('code',$code)
            ->where('date_added',date('Y-m-d'))
            ->first();

        if($bmi){
            $height = $bmi->height;
            $weight = $bmi->weight;
        }

        if($diet){
            $diet_code = $diet->diet_code;
            $remarks = $diet->remarks;
        }
        return view('modules.dietary.diet',[
            'code' => $code,
            'weight' => $weight,
            'height' => $height,
            'diet_code' => $diet_code,
            'remarks' => $remarks
        ]);
    }

    public function saveDiet(Request $req)
    {
        $info = HomisParam::getPatRoom($req->code);
        $bmi = array(
            'weight' => $req->weight,
            'height' => $req->height
        );
        $diet = array(
            'diet_code' => $req->diet,
            'remarks' => (isset($req->remarks)) ? $req->remarks: '',
            'ward_code' => $info->wardcode,
            'room_code' => $info->rmintkey
        );

        Bmi::updateOrCreate([
            'code' => $req->code
        ],$bmi);

        Diet::updateOrCreate([
            'code' => $req->code,
            'date_added' => date('Y-m-d')
        ],$diet);

        return redirect()->back()->with('status',[
            'title' => 'Done',
            'status' => 'success',
            'msg' => 'Diet successfully added for '.$req->code
        ]);
    }

    static function getHeightWeight($bmi,$code)
    {
        $r = Bmi::where('code',$code)->first();
        if($r)
            return $r->$bmi;

        return '';
    }

    public function reportChart()
    {
        return view('modules.dietary.reportChart',[
            'title' => 'Generate Chart Report',
            'menu' => 'report.chart',
            'menu_module' => 'menu.dietary',
        ]);
    }

    static function countDietCensus($code)
    {
        $count = Diet::where('diet_code',$code)
                        ->where('date_added',date('Y-m-d'))
                        ->count();
        return $count;
    }

    static function getDietList()
    {
        $diet = array(
            'DAT' => 'Diet as Tolerated',
            'FTW' => 'Food to Watcher',
            'HI FIBER' => 'High Fiber',
            'DFA' => 'Diet for Age',
            'NDCF' => 'No Dark Color Foods',
            'SOFT' => 'Soft Diet',
            'HYPO' => 'Hypoallergenic',
            'HYPO NDCF' => 'Hypoallergenic, No Dark Color Foods',
            'DIABETIC' => 'Diabetic',
            'LO SALT LO FAT' => 'Low Salt Low Fat',
            'HYPO LO SAL LO FAT' => 'Hypoallergenic Low Salt Low Fat',
            'UREMIC' => 'Uremic Diet',
            'LO POTASSIUM' => 'Low Potassium',
            'LO PURINE' => 'Low Purine',
            'LO OXALATE' => 'Low Oxalate',
            'LIQUID DIET' => 'Liquid Diet',
            'BLENDERIZE FEEDING' => 'Blenderize Feeding'
        );

        return $diet;
    }

    public function reportRoom()
    {
        $room = Room::select(
                        'hroom.rmname as room',
                        'hward.wardname as ward',
                        'hroom.rmintkey as room_id'
                    )
                    ->leftJoin('hward','hward.wardcode','=','hroom.wardcode')
                    ->orderBy('hroom.wardcode','asc')
                    ->get();

        return view('modules.dietary.reportRoom',[
            'title' => 'Generate Chart Report',
            'menu' => 'report.room',
            'menu_module' => 'menu.dietary',
            'room' => $room
        ]);
    }

    static function countDietRoom($diet,$room)
    {
        $start = Carbon::now()->startOfDay();
        $end = Carbon::now()->endOfDay();
        $count = Diet::where('diet_code',$diet)
                    ->where('room_code',$room)
                    ->whereBetween('date_added',[$start,$end])
                    ->count();
        return $count;
    }

    public function reportPatient()
    {
        $data = Diet::whereBetween('date_added',[Carbon::now()->startOfDay(),Carbon::now()->endOfDay()])
                ->orderBy('room_code','asc')
                ->get();

        return view('modules.dietary.reportPatient',[
            'title' => 'Patient Per Room Report',
            'menu' => 'report.patient',
            'menu_module' => 'menu.dietary',
            'data' => $data
        ]);
    }


}
