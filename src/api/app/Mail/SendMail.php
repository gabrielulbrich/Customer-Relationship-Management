<?php

namespace App\Mail;

use App\Profile;
use App\User;
use App\Page;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Mailable;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build() {
        return $this->from('g4brielulbrich@gmmail.com')
        ->subject('Recuperar de Senha')
        ->view('email_template')
        ->with('data', $this->data);
    }
}
