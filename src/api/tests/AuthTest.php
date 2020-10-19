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
            'email' => 'mail'.rand(1,100).'@example.com',
            'cpf' => rand(1,100).'103.964.609-2',
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

}
