<?php

namespace App\Http\Controllers;
use App\Mail\InvitationMail;
use App\Mail\VerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendVerificationMail($name, $email, $verification_code){
        $data = ['name'=>$name, 'code'=>$verification_code];
        Mail::to($email)->send(new VerificationMail($data));
    }

    public static function sendInvitationMail($name, $email, $password){
        $data = ['name'=>$name, 'email'=>$email ,'password'=>$password];
        Mail::to($email)->send(new InvitationMail($data));
    }
}
