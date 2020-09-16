<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Http\Requests\LoginFormValidationRequest;
use App\Http\Requests\RegisterFormValidationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Session;

class AdminController extends Controller
{

    public function showHome()
    {
        if (Auth::guard('admin')->check()) {      // if user is already logged in then he should redirected to homepage
            return redirect(route('admin-home'));
        } else {
            return view('admin');
        }
    }
    public function login(LoginFormValidationRequest $request)
    {
        if (Auth::guard('admin')->attempt(['email_address' => $request->loginEmail, 'password' => $request->password, "verified" => 1])) {
            Session::put('adminSuccess', Admin::where('email_address', $request->loginEmail)->get('name'));
            return redirect(route('admin-home'));
        } else if (Auth::guard('admin')->attempt(['email_address' => $request->loginEmail, 'password' => $request->password, "verified" => 0])) {
            return redirect(route('admin-registered'))->with('adminverification', $request->loginEmail);
        } else {
            return redirect()->back()->with('error', "Wrong Login Details.");
        }
    }

    public function register(RegisterFormValidationRequest $req)
    {
        $new_admin = new Admin;
        $new_admin->verification_code = md5(time());
        $new_admin->name = $req->name;
        $new_admin->email_address = $req->email;
        $new_admin->password = bcrypt($req->password1);
        $new_admin->save();
        MailController::sendVerificationMail($new_admin->name, $new_admin->email_address, $new_admin->verification_code);
        return redirect(route('admin-registered'))->with('adminverification', $req->email);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        Session::forget('adminSuccess');
        return redirect(route("admin-page"));
    }

    public function verify(request $request)
    {
        $result = Admin::where('email_address', $request->email)->first();
        if ($result->verification_code == $request->activation_code) {
            Admin::where('email_address', $request->email)->update(['verified' => 1]);
            Session::put('adminSuccess', Admin::where('email_address', $request->email)->get('name'));
            Auth::guard('admin')->loginUsingId(Admin::where('email_address', $request->email)->get('id')[0]->id);
            return redirect(route("admin-home"))->with("Activated", "Your Account has been activated.");   // redirecting to verification code entry page.
        } else {
            return redirect()->back()->with('ActivationError', "Wrong Activation Code.");
        }
    }
}
