<?php

namespace App\Http\Controllers;

use App\Mail\VerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendVerificationMail($name, $email, $verification_code){
        $data = ['name'=>$name, 'code'=>$verification_code];
        Mail::to($email)->send(new VerificationMail($data));

    }
}
