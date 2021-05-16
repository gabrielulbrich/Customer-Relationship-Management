<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Api extends Model
{
    use Authenticatable, Authorizable;

    protected $fillable = ['page_id', 'api', 'fields', 'weight'];

    protected $casts = [
        'fields' => 'json',
    ];
}
