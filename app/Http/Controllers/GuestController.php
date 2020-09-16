<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Guest;
use App\Http\Requests\GuestLoginValidationRequest;
use App\Soiree_Function;
use Illuminate\Support\Facades\Hash;
use Session;
use Auth;

class GuestController extends Controller
{
    public function index()
    {
        if (Auth::guard('guest')->check()) {
            return redirect(route("guest-homepage"));
        } else {
            return view('guest');
        }
    }

    public function login(GuestLoginValidationRequest $request)
    {
        if (Auth::guard('guest')->attempt(['email' => $request->guestEmail, 'password' => $request->password, "verified" => 1])) {
            $result = Guest::where('email', $request->guestEmail)->first();
            $date = Soiree_Function::distinct()->where('Date', '>=', date("Y-m-d"))->orderBy('Date')->get(['Date'])->first();
            $function = Soiree_Function::where("Date", $date["Date"])->orderBy("event_time")->get();
            $i = 0;
            foreach ($function as $el) {
                $i++;
                $obj["function"] = $el['Name'];
                $obj["time"] = $el["function_start"];
                $obj["date"] = $el["Date"];
                $obj["event" . $i] = $el["event"];
                $obj["eventTime" . $i] = $el["event_time"];
            }
            $obj["name"] = $result->name;
            $obj['email'] = $result->email;
            $obj['phone'] = $result->phone;
            $obj["count"] = $i;
            Session::put('guestsuccess', json_encode($obj));
            return redirect(route(('guest-homepage')));
        } else {
            return redirect()->back()->with('error', "Wrong Login Details.");
        }
    }

    public function logout()
    {
        Auth::guard('guest')->logout();
        Session::forget('guestsuccess');
        return redirect(route("guest-login"));
    }
}
