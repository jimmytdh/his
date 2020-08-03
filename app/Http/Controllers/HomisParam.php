<?php

namespace App\Http\Controllers;

use App\Homis\Bed;
use App\Homis\PatRoom;
use App\Homis\Room;
use App\Homis\Ward;
use Illuminate\Http\Request;

class HomisParam extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
    }

    static function getPatRoom($hpercode)
    {
        $data = PatRoom::where('hpercode',$hpercode)
                    ->orderBy('hprtime','desc')
                    ->first();
        return $data;
    }

    static function getWard($wardcode)
    {
        return Ward::where('wardcode',$wardcode)->first()->wardname;
    }

    static function getRoom($rmintkey)
    {
        $data = Room::where('rmintkey',$rmintkey)->first();
        if($data)
            return $data->rmname;

        return '-';
    }

    static function getBed($bdintkey)
    {
        $data = Bed::where('bdintkey',$bdintkey)->first();
        if($data)
            return $data->bdname;
        return '-';
    }
}
