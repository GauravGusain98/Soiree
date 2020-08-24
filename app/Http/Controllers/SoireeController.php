<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Auth;
class SoireeController extends Controller
{

    public function showHome(){
        if(Auth::check()){
            return redirect('admin/home');
        }
        else 
        return view('admin');
    }
    public function login(request $req, Admin $admin){
        if($req['loginEmail']!=""){
            $str=explode("@",$req['loginEmail']);
            $email = $str[0] . "@gmail.com";
            $req->merge(array('loginEmail' => $email));
        }
        $password = request()->get('password');
        request()->validate([
            'loginEmail'=>'required',
            'password'=>'required'
        ],["loginEmail.required"=>"The Email is required."]);
        if(Auth::attempt(['email_address'=> $email,'password'=> $password]))
        {
            return redirect('/admin/home');
        }
        else{
            return back()->with('error', "Wrong Login Details.");
        }
    }

    public function register(request $req, Admin $new_admin){
        if($req['email']!=""){
            $str=explode("@",$req['email']);
            $email = $str[0] . "@gmail.com";    
            $req->merge(array('email' => $email));
        }
        request()->validate([
            'name'=>'required',
            'email'=>'required| unique:admins,email_address',
            'password1'=>'required|min:5',
            'password2'=> ['required', 'min:5', "same:password1"]
        ],[
           "password1.required"=>'The Password field is required.',
            'password2.required'=>'Password Confirmation is required.',
            "password2.same"=>"Password didn't match.",
            "email.unique"=>"Email already exists."
        ]); 

                $new_admin->name = request()->name;
                $new_admin->email_address = request()->email;
                $new_admin->password = bcrypt(request()->password1);
                $new_admin->save();
                return view("registered_success");
           
    }

    public function logout(){
        request()->session()->flush();
        return redirect("http://soiree.test/soiree");
    }
}
