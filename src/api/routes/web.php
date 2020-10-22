<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function ($router) {
    $router->get('me', 'AuthController@me');
    $router->get('refresh', 'AuthController@refresh');
    $router->get('logout', 'AuthController@logout');

    $router->get('users/search', 'UserController@searchUsers');

    $router->get('leads', 'LeadController@getAllLeads');
    $router->put('/lead/status', 'LeadController@updateStatus');
    $router->put('/lead/priority', 'LeadController@updatePriority');
    $router->put('/lead/user', 'LeadController@updateUser');
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');

//    $router->post('/api/login', 'UserController@login');
//
//    $router->post('/api/user', 'UserController@store');
//    $router->get('/api/user/{id}', 'UserController@view');
//    $router->put('/api/user/{id}', 'UserController@update');
});



