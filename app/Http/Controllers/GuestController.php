<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Guest;
use Illuminate\Support\Facades\Hash;
use Session;

class GuestController extends Controller
{
    public function index(){
        return view('guest');
    }

    public function login(request $request){
        $count =  Guest::where('email', $request->login_email)->count();
        if($count > 0)
        {
            $result=Guest::where('email', $request->login_email)->first();
            if(Hash::check($request->login_password,$result->password) && $result->verified == 1)
            {
                Session::put('success',  $result->name );
                return redirect('/guest/home');
            }
            else{
                return back()->with('error', "Wrong Login Details.");
            }
        }
        else{
            return back()->with('error', "Email didn't exist.");
        }
    }

    public function logout(){
        request()->session()->flush();
        return redirect("http://soiree.test/guest/login");
    }
}