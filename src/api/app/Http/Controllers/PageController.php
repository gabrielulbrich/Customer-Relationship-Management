<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    private $messages = [
        'required' => 'O campo :attribute é obrigatório.',
        'min' => 'A quantidade mínima de caracteres é :min',
        'email' => 'Digite um e-mail válido',
        'confirmed' => 'As senhas não coincidem',
        'password' => 'Senha atual errada.',
    ];

    public function getAllPages()
    {
        $pages = Page::all();

        return response()->json($pages);
    }

    //todo: validar se request e feita pelo MASTER
    public function store(Request $request)
    {
        $dataValidation = [
            'page.name' => 'required|string|max:255',
            'page.site' => 'required|string|max:255',
            'page.epic' => 'required|string|max:255',
            'page.token' => 'required|string|max:255',
            'page.refer' => 'required|string|max:255',
            'user.name' => 'required|string',
            'user.email' => 'required|unique:users,email|email:rfc,dns',
            'user.cpf' => 'required|string|unique:users,cpf',
            'user.password' => 'required|confirmed|max:255|min:6',
        ];
        $this->validate($request, $dataValidation, $this->messages);

        try{
            $page = new Page;
            $page->name = $request->input('page')['name'];
            $page->site = $request->input('page')['site'];
            $page->epic = $request->input('page')['epic'];
            $page->token = $request->input('page')['token'];
            $page->refer = $request->input('page')['refer'];
            $page->logo_url = "/assets/page_icons/page.png";
            $page->save();

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->cpf = $request->input('cpf');
            $user->avatar_url = "/assets/user_icons/user.png";
            $user->password = app('hash')->make($request->input('password'));
            $user->save();
            $user->page()->attach([$page->id], ['profile_id' => 1 ]);
            $user->avatar = $user->avatar_url;

            return response()->json([
                'user'      => $user,
                'page'      => $page,
            ]);

        } catch (\Exception $e) {
            return response()->json( [
            'entity' => 'pages',
            'action' => 'create',
            'result' => 'failed'
            ], 409);
        }
    }

    //todo: validar se usuario master esta fazenndo requisicao
    public function update(Request $request)
    {
        $dataValidation = [
            'page.id' => 'required|numeric',
            'page.name' => 'required|string|max:255',
            'page.site' => 'required|string|max:255',
            'page.epic' => 'required|string|max:255',
        ];

        $this->validate($request, $dataValidation, $this->messages);
        $page = Page::find($request->input('page')['id']);
        $page->name = $request->input('page')['name'];
        $page->site = $request->input('page')['site'];
        $page->epic = $request->input('page')['epic'];
        $page->update();

        return response()->json($page);
    }

    //todo: validar se usuario master esta fazendo requisicao
    public function delete(Request $request)
    {
        $dataValidation = [
            'id' => 'required|numeric',
        ];
        $this->validate($request, $dataValidation, $this->messages);


        $page = Page::find($request->input('id'));
        $page->pages()->detach();
        $page->destroy($request->input('id'));

        return response()->json($page, 200);
    }

    //todo: validar se usuário admin está fazendo a requisição
    public function getNotifications() {
        $user = User::find(Auth::id());
        $page_user = $user->page()->first();
        return $page_user->users()->where('profile_id', 3)->get();
    }

    //todo: validar se usuário admin está fazendo a requisição
    public function answerNotification(Request $request) {
        $user_admin = User::find(Auth::id());
        if ($request->input('answer') == TRUE) {
            $user = User::find($request->input('user_id'));
            $user->profile = $user->profile()->first();
            $user->profile()->updateExistingPivot($user->profile->code, ['profile_id' => 2]);
        } else {
            $user = User::find($request->input('user_id'));
            $user->profile = $user->profile()->first();
            $user->profile()->updateExistingPivot($user->profile->code, ['profile_id' => 4]);
        }

        return $user;
    }
}
