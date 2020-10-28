<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Priority extends Model
{
    use Authenticatable, Authorizable;

    protected $table = "priorities";

    protected $hidden = ['priority', 'id', 'icon_url'];
}
