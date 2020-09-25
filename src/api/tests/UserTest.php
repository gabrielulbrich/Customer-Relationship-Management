<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
//    use DatabaseTransactions;
//
//    public $dados = [];
//
//
//    public function __construct($name = null, array $data = [], $dataName = '')
//    {
//        parent::__construct($name, $data, $dataName);
//        $this->dados = [
//            'name' => 'Nome 01'.date('Ymdis').' '.rand(1,100),
//            'email' => 'email3@exemplo.com',
//            'password' => '123',
//            'password_confirmation' => '123'
//        ];
//
//    }
//
//    /**
//     * A basic test example.
//     *
//     * @return void
//     */
//    public function testCreateUser()
//    {
//        $this->post('/api/user', $this->dados);
//        $this->assertResponseOk();
//
//        $response = (array) json_decode($this->response->content());
//        $this->assertArrayHasKey('name',$response);
//        $this->assertArrayHasKey('email', $response);
//        $this->assertArrayHasKey('id', $response);
//
//        $this->seeInDatabase('users', [
//            'name' => $this->dados['name'],
//            'email' => $this->dados['email']
//        ]);
//    }
//
//    public function testViewUser()
//    {
//        $user = \App\User::first();
//
//        $this->get('/api/user/'. $user->id);
//
//        $this->assertResponseOk();
//        $response = (array) json_decode($this->response->content());
//        $this->assertArrayHasKey('name',$response);
//        $this->assertArrayHasKey('email', $response);
//        $this->assertArrayHasKey('id', $response);
//    }
//
////    public function testAllUser()
////    {
////        $this->get('/api/users');
////
////        $this->assertResponseOk();
////        $this->seeJsonStructure([
////            '*' => [
////                'id',
////                'name',
////                'email'
////            ]
////        ]);
////    }
////
////    public function testDeleteUser()
////    {
////        $user = \App\User::first();
////        $this->delete('/api/user/'.$user->id);
////        $this->assertResponseOk();
//////        $this->assertEquals("Removido ");
////    }
//    public function testUpdateUserWithoutPassword()
//    {
//        $user = \App\User::first();
//        $dados = [
//            'name' => 'Nome Edit',
//            'email' => 'emaileditttttt@exemplo.com',
//        ];
//
//        $this->put('/api/user/'.$user->id, $dados);
//
//        $this->assertResponseOk();
//        $response = (array) json_decode($this->response->content());
//        $this->assertArrayHasKey('name',$response);
//        $this->assertArrayHasKey('email', $response);
//        $this->assertArrayHasKey('id', $response);
//
//        $this->notSeeInDatabase('users', [
//            'name' => $user->name,
//            'email' => $user->email,
//            'id' => $user->id,
//        ]);
//    }
//
//    public function testUpdateUserWithPassword()
//    {
//        $user = \App\User::first();
//
//        $this->put('/api/user/'. $user->id, $this->dados);
//
//        $this->assertResponseOk();
//        $response = (array) json_decode($this->response->content());
//        $this->assertArrayHasKey('name',$response);
//        $this->assertArrayHasKey('email', $response);
//        $this->assertArrayHasKey('id', $response);
//
//        $this->notSeeInDatabase('users', [
//            'name' => $user->name,
//            'email' => $user->email,
//            'id' => $user->id,
//        ]);
//    }
//
//    public function testLogin()
//    {
//        $this->post('/api/login', $this->dados);
//        $this->assertResponseOk();
//    }


}
