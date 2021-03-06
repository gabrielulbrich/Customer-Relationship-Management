<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
//use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator;
use  App\User;

class AuthController extends Controller
{

    private $messages = [
        'required' => 'O campo :attribute é obrigatório.',
        'min' => 'A quantidade mínima de caracteres é :min',
        'email' => 'Digite um e-mail válido',
        'unique' => ':attribute já cadastrado',
        'confirmed' => 'As senhas não coincidem',
        'password' => 'Senha atual errada.',
    ];

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $dataValidation = [
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string',
        ];
        $this->validate($request, $dataValidation, $this->messages);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['error' => [ 'auth' => 'E-mail ou senha incorretos']], 401);
        }
        $user = User::find(Auth::id());
        $user->profile = $user->profile()->first();
        $user->avatar = $user->avatar_url;
        return response()->json([
            'user'      => $user,
            'page'      => $user->page->first(),
//            'profile'   => $user->profile->first(),
            'token'     => $this->respondWithToken($token)
        ]);
    }


    /**
     * Get user details.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = User::find(Auth::id());
        return response()->json([
            'user' => $user->first(),
            'page' => $user->page->first(),
            'profile' => $user->profile->first(),
        ]);
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
