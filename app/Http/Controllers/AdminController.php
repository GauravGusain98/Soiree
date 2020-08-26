<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Session;
class AdminController extends Controller
{

    public function showHome(){
        request()->session()->forget('adminverify'); // to ensure that registered_success page should not through url once user again open this page.
        if(Auth::check()){      // if user is already logged in then he should redirected to homepage
            return redirect('admin/home');
        }
        else 
        return view('admin');
    }
    public function login(request $request, Admin $admin){
        request()->session()->flush();   // to ensure that registered_success page should not through url once user again open this page.
        if($request['loginEmail']!=""){                
            $str=explode("@",$request['loginEmail']);   // separating username from email 
            $email = $str[0] . "@gmail.com";            // adding a custom domain name
            $request->merge(array('loginEmail' => $email)); // overwriting the request data
        }           
        request()->validate([                       // form validation
            'loginEmail'=>'required',   
            'password'=>'required'      
        ],["loginEmail.required"=>"The Email is required."]);
        $count =  Admin::where('email_address', $request->loginEmail)->count(); // counting the results
        if($count > 0)      //if email exist.
        {
            $result=Admin::where('email_address', $request->loginEmail)->first();
            if(Hash::check($request->password,$result->password))   // verifying password 
            {
                if($result->verified == 0)     // user account is not activated
                {
                    Session::put('adminverification',  $result->email_address );  // starting a session
                    return redirect('/admin/registered');   // redirecting to verification code entry page.
                }
                else        // user account is activated
                {
                Session::put('adminsuccess',  $result->name );  // starting a session
                return redirect('/admin/home'); // redirecting to home page
                }
            }
            else{   // if password didn't match
                return back()->with('error', "Wrong Login Details.");
            }
        }
        else 
        {     
            return back()->with('error', "Email didn't exist.");
        }
    }

    public function register(request $req, Admin $new_admin){
        request()->session()->flush();
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

        $new_admin->verification_code = md5(time());
        $new_admin->name = request()->name;
        $new_admin->email_address = request()->email;
        $new_admin->password = bcrypt(request()->password1);
        $new_admin->save();
                
        MailController::sendVerificationMail($new_admin->name, $new_admin->email_address, $new_admin->verification_code);
        Session::put('adminverification', $req->email);
        return redirect("/admin/registered");
               
    }

    public function logout(){
        request()->session()->flush();
        return redirect("http://soiree.test/adminpage");
    }

    public function verify(request $request){
        $result=Admin::where('email_address', $request->email)->first();

        if($result->verification_code == $request->activation_code)
        {
            Admin::where('email_address', $request->email)->update(['verified' => 1]);
            Session::put('adminsuccess', $result->name);
            Session::put('AdminVerified',  "Your account has been activated.");  // starting a session
            return redirect('/admin/home')->with("Activated","Your Account has been activated.");   // redirecting to verification code entry page.
        }
        else{
            return redirect()->back()->with('ActivationError', "Wrong Activation Code.");
        }
    }
}
