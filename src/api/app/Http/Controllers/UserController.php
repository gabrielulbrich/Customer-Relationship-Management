<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $messages = [
        'required' => 'O campo :attribute é obrigatório.',
        'min' => 'A quantidade mínima de caracteres é :min',
        'email' => 'Digite um e-mail válido',
        'confirmed' => 'As senhas não coincidem',
        'password' => 'Senha atual errada.',
        'exists' => 'O site informado não ainda não foi cadastrado no site. Entre em contato com um administrador.'
    ];

    public function view($id) {
        return User::find($id);
    }

    //todo: BUSCAR APENAS POR USUARIOS DA PAGINA
    public function searchUsers(Request $request)
    {
        $user = User::find(Auth::id());
        if (!empty($request->input('username'))){
            $page_user = $user->page()->first();
            $page_user = $page_user->users()
                ->where( "name", "LIKE", "%{$request->input('username')}%" )
                ->where("profile_id", "!=", [3,4,5])
                ->limit('20')
                ->get();
        }else {
            $page_user = $user->page()->first();
            $page_user = $page_user->users()
                ->where("profile_id", "!=", [3,4,5])
                ->get();
        }
        return response()->json($page_user);
    }

    //todo: validar se a request foi feita pelo admin
    public function allUsersFromPage(){
        $user = User::find(Auth::id());
        $page_user = $user->page()->first();
        $page_user = $page_user->users()->where('user_id', '!=', 1)->get(); //remove ninguem da lista

        $profiles = Profile::all('id as code', 'profile as name');
        foreach ($page_user as $user){
            $user->avatar = $user->avatar_url;
            $user->profile = $user->profile()->first();
        }

        return response()->json([
            'users' =>  $page_user,
            'profiles' => $profiles,
        ]);
    }

    //todo: validar se usuario que esta sendo alteado pertence a mesma pagina do admin que esta alterando.
    //todo: validar se a request foi feita pelo próprio usuário
    public function update(Request $request)
    {
        if ($request->has('password')){
            $dataValidation['current_password'] = 'password:api';
            $dataValidation['password'] = 'required|confirmed|max:255|min:6';
            $this->validate($request, $dataValidation, $this->messages);
        } else if ($request->has('name')){
            $dataValidation['name'] = 'required|min:3|max:255';
            $this->validate($request, $dataValidation, $this->messages);
        } else if ($request->has('email')){
            $dataValidation['email'] = 'unique:users|required|min:3|max:255|email:rfc,dns';
            $this->validate($request, $dataValidation, $this->messages);
        }

        $user = User::find(Auth::id());
        $user->name = $request->has('name') ? $request->input('name') : $user->name;
        $user->email = $request->has('email') ? $request->input('email') : $user->email;
        $user->password = $request->has('password') ? app('hash')->make($request->input('password')) : $user->password;
        $user->avatar_url = $request->has('avatar_url') ? $request->input('avatar_url') : $user->avatar_url;

        $user->update();
        
        $user->avatar = $user->avatar_url;

        return response()->json($user);
    }

    //todo: validar se a request foi feita pelo admin
    public function updateProfile(Request $request){
        if ($request->has('profile_id')){
            $dataValidation['profile_id'] = 'required';
        }
        $this->validate($request, $dataValidation, $this->messages);

        $user = User::find($request->input('user_id'));
        $user->profile = $user->profile()->first();

        $user->profile()->updateExistingPivot($user->profile->code, ['profile_id' => $request->input('profile_id')]); //

        return response()->json($user);
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    //todo: validar se a request foi feita pelo admin
    public function store(Request $request)
    {
        $dataValidation = [
            'name' => 'required|string',
            'email' => 'required|unique:users|email:rfc,dns',
            'cpf' => 'required|string|unique:users',
            'password' => 'required|confirmed|max:255|min:6',
            'profile' => 'required'
        ];
        $this->validate($request, $dataValidation, $this->messages);

        $user_admin = User::find(Auth::id());
        $page_user = $user_admin->page()->first();

        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->cpf = $request->input('cpf');
            $user->avatar_url = "/assets/user_icons/user.png";
            $user->password = app('hash')->make($request->input('password'));
            $user->save();
            $user->page()->attach([$page_user->id], ['profile_id' => $request->input('profile')['code']]);
            $user->avatar = $user->avatar_url;
            $user->profile = $user->profile()->first();

            return response()->json($user, 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json( [
                'entity' => 'users',
                'action' => 'create',
                'result' => 'failed'
            ], 409);
        }
    }

    //todo: validar se a request foi feita pelo admin
    public function delete(Request $request)
    {
        $dataValidation = [
            'user_id' => 'required|numeric',
        ];
        $this->validate($request, $dataValidation, $this->messages);

        $user = User::find($request->input('user_id'));
        $user->user()->detach();
        $user->destroy($request->input('user_id'));

        return response()->json($user, 200);
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function newAccount(Request $request)
    {
        $dataValidation = [
            'name' => 'required|string',
            'email' => 'required|unique:users|email:rfc,dns',
            'cpf' => 'required|string|unique:users',
            'password' => 'required|confirmed|max:255|min:6',
            'site_name'  => 'required|exists:pages,site|max:255'
        ];
        $this->validate($request, $dataValidation, $this->messages);

        $site = Page::firstWhere('site', $request->input('site_name'));

        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->cpf = $request->input('cpf');
            $user->avatar_url = "/assets/user_icons/user.png";
            $user->password = app('hash')->make($request->input('password'));
            $user->save();
            $user->page()->attach([$site->id], ['profile_id' => 3]);
            $user->avatar = $user->avatar_url;

            return response()->json($user, 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json( [
                'errors' => [
                    'message' => $e->getMessage()
                ],
            ], 409);
        }
    }

    public function resetPassword(Request $request) {
        $dataValidation = [
            'token' => 'required|string',
            'password' => 'required|confirmed|max:255|min:6',
        ];

        $this->validate($request, $dataValidation, $this->messages);

        $user = new User;

        $user = User::where('token', $request->input('token'))->first();

        if (empty($user))
            return response()->json(['invalid_token' => ['Token Inválido']], 422);

        $user->password = app('hash')->make($request->input('password'));
        $user->token = null;

        $user->save();

        return response()->json(['success' => ['Senha Alterada']], 200);
    }
}
