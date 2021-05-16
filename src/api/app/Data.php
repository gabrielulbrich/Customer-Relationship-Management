<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $fillable = ['api_id', 'data'];

    protected $casts = [
        'data' => 'json',
    ];
}