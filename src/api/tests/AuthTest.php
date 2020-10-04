<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public $token;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function testRegister(){
        $dados = [
            'name' => 'Nome 01'.date('Ymdis').' '.rand(1,100),
            'email' => 'maill@example.com',
            'cpf' => '103.964.609-330',
            'cep' => '81450-220',
            'number' => '123',
            'site' => 'test.com.br',
            'password' => '123',
            'password_confirmation' => '123'
        ];

        $this->post('/api/register', $dados);
        $this->response
            ->assertStatus(201)
            ->assertJson([
                'created' => true,
            ]);
    }

    public function testLogin()
    {
        $dados = [
            'email' => 'teste@example.com',
            'password' => 'secret',
        ];
        $this->post('/api/login', $dados);
        $this->assertResponseOk();

        $response = (array) json_decode($this->response->content());
        $this->assertArrayHasKey('token', $response);

    }

//    public function testMe(){
//
//        $token = JWTAuth::fromUser('teste@example.com');
//        dd($token);
////        $token = \Tymon\JWTAuth\JWTAuth::fromUser('teste@example.com');
////        $token = Tymon\JWTAuth\::fromUser('teste@example.com');
////        dd($token);
//        $this->get('/api/me', [
//            'headers' => [
//                'Authorization' => `Bearer ${token}`
//            ]
//        ]);
//
//
//        $this->get('/api/me')->seeJsonContains('token');
//
////        dd($token);
////        $response2 = (array) json_decode($this->response->content());
////        $this->assertArrayHasKey('id', $response2);
////        $this->assertArrayHasKey('name', $response2);
////        $this->assertArrayHasKey('email', $response2);
////        dd($response2);
//
//    }
}
