<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guard = "admin";
    protected $table = "admins";

    protected $fillable =  ['name', 'email_address', 'verified'];

    protected $hidden = [
        'password', 'verification_code'
    ];
}
