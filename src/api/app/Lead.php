<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Lead extends Model
{
    use Authenticatable, Authorizable;

//    /**
//     * The attributes that are mass assignable.
//     *
//     * @var array
//     */
//    protected $fillable = [
//        'name', 'site'
//    ];
//
//    /**
//     * The attributes excluded from the model's JSON form.
//     *
//     * @var array
//     */
    protected $hidden = [
        'priority_id', 'status_id', 'user_id'
    ];

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

    public function histories(){
        return $this->belongsToMany('App\History','leads_history')->orderBy('created_at', 'desc');
    }

}
