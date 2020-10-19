<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;

use Tymon\JWTAuth\Facades\JWTAuth;

class LeadTest extends TestCase
{
    use DatabaseTransactions;

    public $user;
    public $token;


    protected function createAuthenticatedUser()
    {
        $this->user  = factory(App\User::class, 'test')->create();
        $this->token = JWTAuth::fromUser($this->user);
        JWTAuth::setToken($this->token);
        Auth::attempt(['email' => $this->user->username, 'password' => $this->user->password]);
    }

    protected function callAuthenticated($method, $uri, array $data = [], array $headers = [])
    {
        if ($this->token && !isset($headers['Authorization'])) {
            $headers['Authorization'] = "Bearer $this->token";
        }

        $server = $this->transformHeadersToServerVars($headers);
        $this->call(strtoupper($method), $uri, $data, [], [], $server);

        return $this;
    }

    public function testGetLeads()
    {
        $this->createAuthenticatedUser();
        $response = $this->callAuthenticated('GET', '/api/leads');
//        dd($response);
    }

}
