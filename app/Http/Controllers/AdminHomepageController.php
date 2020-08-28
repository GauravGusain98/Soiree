<?php

namespace App\Http\Controllers;
use App\Guest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Session;
use Auth;


class AdminHomepageController extends Controller
{
    public function showRequests(){
        $results = Guest::where('verified', 0)->select('name', 'email', 'phone', 'message')->get();
        return response()->json($results);
    }

    public function showGuests(){
        $results = Guest::where('verified', 1)->select('name', 'email', 'phone')->get();
        return response()->json($results);
    }

    public function status(request $request){
        if($request->value == "approve"){
            $password = md5(time());
            Guest::where('email', $request->email)->update(['verified' => 1, 'password' => $password]);
            MailController::sendInvitationMail($request->name, $request->email, $password);
            echo 'approved';
        }
        else{
            Guest::where('email', $request->email)->update(['verified' => -1]);
            echo 'disapproved';
        }
    }

    public function showCancelledRequests(){
        $results = Guest::where('verified', -1)->select('name', 'email', 'phone', 'message')->get();
        return response()->json($results);
    }

    public function changeStatus(request $request){
            $password = md5(time());
            Guest::where('email', $request->email)->update(['verified' => 1, 'password' => $password]);
            MailController::sendInvitationMail($request->name, $request->email, $password);
            echo 'approved';
        
    }

}
