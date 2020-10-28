<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class History extends Model
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
//    protected $hidden = [
//        'token', 'refer', 'pivot'
//    ];


    public function lead(){
        return $this->belongsToMany('App\Lead','leads_history');
    }

}
