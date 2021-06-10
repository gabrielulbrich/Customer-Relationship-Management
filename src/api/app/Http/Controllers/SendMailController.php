<?php

namespace App\Http\Controllers;

use \App\User;
use \App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Illuminate\Routing\UrlGenerator;

class SendMailController extends Controller
{
    private $messages = [
        'required' => 'O campo :attribute é obrigatório.',
        'min' => 'A quantidade mínima de caracteres é :min',
        'email' => 'Digite um e-mail válido',
        'unique' => ':attribute já cadastrado',
        'confirmed' => 'As senhas não coincidem',
        'password' => 'Senha atual errada.',
    ];

    public function sendMail(Request $request) {
        $dataValidation = [
            'recover_email' => 'required|email:rfc,dns',
        ];
        
        $this->validate($request, $dataValidation, $this->messages);

        $user = User::where('email', $request->input('recover_email'))->first();

        if (empty($user))
            return response()->json(['recover_email' => ['E-mail não encontrado']], 422);

        $token = uniqid();
        $user->token = $token;
        $user->save();

        Mail::to($request->input('recover_email'))->send(new SendMail(array(
            'user' => $user->name,
            'token' => env('APP_URL').'/recover-password/'.$token
        )));


        return array('token' => $token);
    }
}