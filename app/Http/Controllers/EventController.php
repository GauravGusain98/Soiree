<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Soiree_Function;

class EventController extends Controller
{
    public function addFunction(request $request){
        $count = $request->count;
        if($count==0){
                $function_data =new Soiree_Function;
                $function_data->name = $request->functionName;
                $function_data->Date = $request->functionDate;
                $function_data->function_start = $request->functionTime;
                $function_data->save();
        }
        else{
            for($i=1;$i<=$count;$i++)
            {
                $function_data =new Soiree_Function;
                $function_data->name = $request->functionName;
                $function_data->Date = $request->functionDate;
                $function_data->function_start = $request->functionTime;
                $function_data->event = $request["eventName_".$i];
                $function_data->event_time = $request["eventTime_".$i];
                $function_data->save();
            }
        }

    }
}
