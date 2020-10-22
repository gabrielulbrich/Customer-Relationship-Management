<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function view($id) {
        return User::find($id);
    }

    public function searchUsers(Request $request){
        if (!empty($request->input('username'))){
            $users = User::select( 'id','name','email', 'avatar_url' )
                ->where( "name", "LIKE", "%{$request->input('username')}%" )
                ->limit('20')
                ->get();
        }else {
            $users = User::select( 'id','name','email', 'avatar_url' )
                ->limit('20')
                ->get();
        }

        return response()->json($users);
    }

    public function update(Request $request, $id){
        $dataValidation = [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
        ];

        if ($request->has('password')){
            $dataValidation['password'] = 'required|confirmed|max:255';
        }

        $this->validate($request, $dataValidation);
        $user = User::find($id);
        $user->name = $request->has('name') ? $request->input('name') : $user->name;
        $user->email = $request->has('email') ? $request->input('email') : $user->email;
        $user->password = $request->has('password') ? $request->input('password') : $user->password;

        $user->update();
        return $user;
    }

}
