<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Guest;
use App\Soiree_Function;
use Illuminate\Support\Facades\Hash;
use Session;

class GuestController extends Controller
{
    public function index(){
        return view('guest');
    }

    public function login(request $request){
        request()->session()->flush();
        $count =  Guest::where('email', $request->login_email)->count();
        if($count > 0)
        {
            $result=Guest::where('email', $request->login_email)->first();
            $date = Soiree_Function::distinct()->where('Date', '>=', date("Y-m-d"))->orderBy('Date')->get(['Date'])->first();
            $function = Soiree_Function::where("Date", $date["Date"])->orderBy("event_time")->get();
            if($request->login_password == $result->password && $result->verified == 1)
            {
                $i=0;
                foreach($function as $el){
                    $i++;
                    $obj["function"] = $el['Name'];
                    $obj["time"] = $el["function_start"];
                    $obj["date"] = $el["Date"];
                    $obj["event".$i] = $el["event"];
                    $obj["eventTime".$i] = $el["event_time"];            
                } 
                $obj["password"] = $request->login_password;
                $obj["name"] = $result->name;
                $obj['email'] = $result->email;
                $obj['phone'] = $result->phone;
                $obj["count"] = $i;
                Session::put('guestsuccess', json_encode($obj));
                return redirect(route(('guest-homepage')));            
            }
            else{
                return back()->with('error', "Wrong Login Details.");
            }
        }
        else{
            return back()->with('error', "Wrong Login Details.");
        }
    }

    public function logout(){
        request()->session()->flush();
        return redirect(route("guest-login"));
    }
}