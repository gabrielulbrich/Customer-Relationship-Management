<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|confirmed|max:255'
        ]);
        $user = new User($request->all());
//        $user->api_token = str_random(60);
        $user->save();
        return $user;
    }



    public function view($id) {
        return User::find($id);
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

    public function login(Request $request){
        $dados = $request->only('email', 'password');
        $user = User::where('email', $dados['email'])
            ->where('password', $dados['passowrd'])
            ->first();
//        $user->api_token =
        return $user->api_token;
    }

}
