<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Page extends Model
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'site'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'token', 'refer', 'pivot'
    ];


    public function users(){
        return $this->belongsToMany('App\User','users_pages');
    }

    public function pages(){
        return $this->belongsToMany('App\Page','users_pages');
    }
}
