<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;

class SoireeController extends Controller
{
    public function showAdmin(){
        request()->validate([
            'loginEmail'=>'required',
            'password'=>'required'
        ]);
        $login = new Admin();
        $login->email = request()->email . "@gmail.com";
        $login->password =request()->password;
    }

    public function createAdmin(){
        request()->validate([
            'name'=>'required',
            'email'=>'required',
            'password1'=>'required| min:5',
            'password2'=> ['required', 'min:5', "same:password1"]
        ]); 
            $admin = new Admin();
            $admin->name = request()->name;
            $admin->email = request()->email . "@gmail.com";
            $admin->password = request()->password1;
            $admin->save();
    }
}
