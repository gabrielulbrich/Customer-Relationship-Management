<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public $dados = [];
    public $token;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->dados = [
            'name' => 'Nome 01'.date('Ymdis').' '.rand(1,100),
            'email' => 'mail@example.com',
            'password' => '123',
            'password_confirmation' => '123'
        ];
    }

    public function testRegister(){
        $this->post('/api/register', $this->dados);
        $this->response
            ->assertStatus(201)
            ->assertJson([
                'created' => true,
            ]);

        $response = (array) json_decode($this->response->content());
        $this->assertObjectHasAttribute('name',$response['user']);
        $this->assertObjectHasAttribute('email',$response['user']);

        $this->seeInDatabase('users', [
            'name' => $this->dados['name'],
            'email' => $this->dados['email']
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
