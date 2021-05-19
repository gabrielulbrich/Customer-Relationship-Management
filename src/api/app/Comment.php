<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Comment extends Model
{
    use Authenticatable, Authorizable;

    public function lead(){
        return $this->belongsToMany('App\Lead','leads_comments');
    }
}
