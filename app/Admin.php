<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;


class Admin extends Model
{
    function getUser($email){
            $data= DB::table('admins')->where("email_address",$email)->get();
            return $data;
    }  
    function getPassword($email){
        $data= Admin::where("email",$email);
            return $data;
    }
}
