<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $messages = [
        'required' => 'O campo :attribute é obrigatório.',
        'min' => 'A quantidade mínima de caracteres é :min',
        'email' => 'Digite um e-mail válido',
        'confirmed' => 'As senhas não coincidem',
        'password' => 'Senha atual errada.',
    ];

    public function view($id) {
        return User::find($id);
    }

    public function searchUsers(Request $request)
    {
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

    public function update(Request $request)
    {
        if ($request->has('password')){
            $dataValidation['current_password'] = 'password:api';
            $dataValidation['password'] = 'required|confirmed|max:255|min:6';
        } else if ($request->has('name')){
            $dataValidation['name'] = 'required|min:3|max:255';
        } else if ($request->has('email')){
            $dataValidation['email'] = 'unique:users|required|min:3|max:255|email:rfc,dns';
        }

        $this->validate($request, $dataValidation, $this->messages);
        $user = User::find(Auth::id());
        $user->name = $request->has('name') ? $request->input('name') : $user->name;
        $user->email = $request->has('email') ? $request->input('email') : $user->email;
        $user->password = $request->has('password') ? app('hash')->make($request->input('password')) : $user->password;

        $user->update();
        return $user;
    }

}
