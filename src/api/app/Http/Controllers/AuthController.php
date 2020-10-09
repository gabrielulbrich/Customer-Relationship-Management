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
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'cpf' => 'required|string',
            'cep' => 'required|string',
            'number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->cpf = $request->input('cpf');
            $user->profile_id = 2;
            $user->cep = $request->input('cep');
            $user->number = $request->input('number');
            $user->complement = $request->input('complement');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'created' => 'true'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json( [
                'entity' => 'users',
                'action' => 'create',
                'result' => 'failed'
            ], 409);
        }

    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['error' => [ 'auth' => 'E-mail ou senha incorretos']], 401);
        }
        $user = User::find(Auth::id());
        return response()->json([
            'user'      => $user->first(),
            'page'      => $user->page->first(),
            'profile'   => $user->profile->first(),
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
