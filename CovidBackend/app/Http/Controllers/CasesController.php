<?php

namespace App\Http\Controllers;

use App\Cases;
use Illuminate\Http\Request;
use App\State;

class CasesController extends Controller
{


    public function show($state_id)
    {

        $stateName = State::where('id' , '=' , $state_id)->pluck('name');

        $returnData = [
            "data"=>[$this->deaths($state_id) , $this->recovered($state_id) , $this->confirmed($state_id)],
            "startdate" => $this->dates($state_id),
            "stateName" => $stateName[0]

        ];

        return response()->json($returnData);
    }

    public function deaths($state_id){
        $data = Cases::where('state_id' , '=' , $state_id)->pluck('deaths');

        $returnArray = array(
            "name" => "Deaths",
            "data" => $data
        );
        return $returnArray;
        return response()->json($returnArray);
    }
    protected function recovered($state_id){
        $data = Cases::where('state_id' , '=' , $state_id)->pluck('recovered');

        $returnArray = array(
            "name" => "Recovered",
            "data" => $data
        );

        return $returnArray;
        return response()->json($returnArray);
    }
    protected function confirmed($state_id){
        $data = Cases::where('state_id' , '=' , $state_id)->pluck('confirmed');

        $returnArray = array(
            "name" => "Confirmed",
            "data" => $data
        );

        return $returnArray;
        return response()->json($returnArray);
    }

    public function dates($state_id){
        $data = Cases::select("date")->where('state_id' , '=' , $state_id)->orderBy('date','asc')->first();

        $year = date('Y', strtotime($data->date));
        $month = date('m', strtotime($data->date));
        $day = date('d', strtotime($data->date));

        $returnArray = array(
            "year" => $year,
            "month" =>  $month,
            "day" => $day
        );

        return $returnArray;

        return response()->json($data);
    }

    public function total(){
        $returnArray = array(
            "confirmed" => number_format(Cases::sum("confirmed")),
            "deaths" => number_format(Cases::sum("deaths")),
            "recovered" => number_format(Cases::sum("recovered"))
        );
        return response()->json($returnArray);
    }


}
