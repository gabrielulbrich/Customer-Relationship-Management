<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
//use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator;
use  App\User;
use  App\Api;

class ApiController extends Controller
{

    public  function select() {
        $user = User::find(Auth::id());
        $page_user = $user->page()->first();

        return response()->json([
            'apis' =>  $page_user->apis()->get(),
        ]);
    }

    public function store() {

    }

    public function update() {

    }

    public function delete() {

    }

}
