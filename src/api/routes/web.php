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
    $router->put('user/update', 'UserController@update');
    $router->put('user/update-profile', 'UserController@updateProfile'); //ONLY ADMIN
    $router->delete('user/delete', 'UserController@delete'); //ONLY ADMIN
    $router->post('user/register', 'UserController@store'); //ONLY ADMIN
    $router->get('users', 'UserController@allUsersFromPage'); //ONLY ADMIN

    $router->get('leads', 'LeadController@getAllLeads');
    $router->get('lead/report', 'LeadController@report');
    $router->get('lead/{leadId}', 'LeadController@getLeadById');
    $router->put('lead/status', 'LeadController@updateStatus');
    $router->put('lead/priority', 'LeadController@updatePriority');
    $router->put('lead/user', 'LeadController@updateUser');
    $router->post('lead/comment', 'LeadController@submitCommentLead');
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('login', 'AuthController@login');

//    $router->post('/api/login', 'UserController@login');
//
//    $router->post('/api/user', 'UserController@store');
//    $router->get('/api/user/{id}', 'UserController@view');
//    $router->put('/api/user/{id}', 'UserController@update');
});



