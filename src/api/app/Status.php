<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Status extends Model
{
    use Authenticatable, Authorizable;

    protected $table = "status";

    protected $hidden = ['status', 'id'];
}
