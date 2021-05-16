<?php

namespace App\Http\Controllers;

use App\Page;
use App\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
//use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator;
use  App\User;
use  App\Api;

class DataController extends Controller
{
    public function select() {
        $user = User::find(Auth::id());
        $page_user = $user->page()->first();
        $columns = [];

        $data = Api::where('page_id', $page_user->id)->get();
        // return $data;
        foreach ($data as $value) {
            $value->data = Data::where('api_id', $value->id)->get();
            foreach ($value->fields as $field) {
                $columns[$value->api][] = array(
                    'field' => 'data.'.$field['name'],
                    'header' => $field['description']
                );
            }
        }
        

        return response()->json([
            'data' =>  $data,
            'columns' => $columns
        ]);
    }
}