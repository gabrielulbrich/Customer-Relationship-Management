<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile_id', 'avatar_url', 'user_id', 'page_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'pivot', 'cpf', 'updated_at', 'created_at', 'page'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function page()
    {
        return $this->belongsToMany('App\Page','users_pages');
    }

    public function users(){
        return $this->belongsToMany('App\User','users_pages', 'page_id');
    }

    public function user(){
        return $this->belongsToMany('App\User','users_pages');
    }

    public function profile(){
        return $this->belongsToMany('App\Profile','users_pages')->select('id as code', 'profile as name')->withPivot('page_id');
    }

    public function profileTest(){
        return $this->belongsToMany('App\Profile','users_pages');
    }
}
