<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Lead extends Model
{
    use Authenticatable, Authorizable;

    protected $hidden = [
        'priority_id', 'status_id', 'user_id'
    ];

    protected $casts = [
        'data' => 'json',
    ];

    protected $filable = ['api_id', 'data'];

    public function priority()
    {
        return $this->belongsTo('App\Priority');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function api()
    {
        return $this->belongsTo('App\Api');
    }

    public function comments(){
        return $this->belongsToMany('App\Comment','leads_comments')->orderBy('created_at', 'desc');
    }

}
