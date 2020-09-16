<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Guest extends Authenticatable
{
    protected $connection = 'wordpress';
}
