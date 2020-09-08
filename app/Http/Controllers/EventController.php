<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Soiree_Function;

class EventController extends Controller
{
    public function addFunction(request $request){
        if(Soiree_Function::where('Date', $request->functionDate)->count() > 0){
            header('HTTP/1.1 500 Internal Server Booboo');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'An event is already booked for the given date.', 'code' => 500)));
        }
        else{
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

    public function showFunction(){
        $date = date("Y-m-d");
        $sql=[];
        $distinct = Soiree_Function::distinct()->where('Date', '>=', $date)->orderBy('Date')->get(['Date']);
        foreach($distinct as $fun_date){
            $data = Soiree_Function::where('Date', $fun_date["Date"])->first();
            $obj=[];
            $obj["Name"]= $data['Name'];
            $obj["Date"]= $data['Date'];
            $obj["Time"]= $data['function_start'];
            $element = Soiree_Function::where('Date', $fun_date['Date'])->get();
            $i=0;
            foreach($element as $el){
                $i++;
                $obj["event".$i] = $el["event"];
                $obj["eventTime".$i] = $el["event_time"];            
            } 
            array_push($sql, $obj);  
        }
        return $sql;
    }
    
    public function deleteFunction(request $request){
        Soiree_Function::where("Date",[$request->date])->delete();
    }
    public function saveFunction(request $request){
        Soiree_Function::where("Date",$request->oldDate)->delete();
        if(Soiree_Function::where('Date', $request->date)->count() > 0){
            header('HTTP/1.1 500 Internal Server Booboo');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'An event is already booked for the given date.', 'code' => 500)));
        }
        else{
            $count = $request->count;
            if($count==0){
                    $function_data =new Soiree_Function;
                    $function_data->name = $request->name;
                    $function_data->Date = $request->date;
                    $function_data->function_start = $request->time;
                    $function_data->save();
            }
            else{
                for($i=1;$i<=$count;$i++)
                {
                    $function_data =new Soiree_Function;
                    $function_data->name = $request->name;
                    $function_data->Date = $request->date;
                    $function_data->function_start = $request->time;
                    $function_data->event = $request["event".$i];
                    $function_data->event_time = $request["eventtime".$i];
                    $function_data->save();
                }
            }
        }
    }
    public function showEditedFunction(request $request){
        $find_date = Soiree_Function::distinct()->where('Date', '>=', date("Y-m-d"))->orderBy('Date')->get(['Date']);
        $date = $find_date[$request->id-1]['Date'];
        $sql = Soiree_Function::where("Date", $date)->orderBy("event_time")->get();
        $i=0;
        foreach($sql as $el){
            $i++;
            $obj["name"] = $el['Name'];
            $obj["time"] = $el["function_start"];
            $obj["date"] = $el["Date"];
            $obj["event".$i] = $el["event"];
            $obj["eventTime".$i] = $el["event_time"];            
        } 
        return $obj;
    }
}
