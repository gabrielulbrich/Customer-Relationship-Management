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

    $router->put('lead/status', 'LeadController@updateStatus');
    $router->get('lead/{leadId}', 'LeadController@getLeadById');
    $router->put('lead/priority', 'LeadController@updatePriority');
    $router->put('lead/user', 'LeadController@updateUser');
    $router->post('lead/comment', 'LeadController@submitCommentLead');

    $router->get('pages', 'PageController@getAllPages'); //ONLY MASTER
    $router->post('page/create', 'PageController@store'); //ONLY MASTER
    $router->put('page/update', 'PageController@update'); //ONLY MASTER
    $router->delete('page/delete', 'PageController@delete'); //ONLY MASTER
    $router->get('page/get-notifications', 'PageController@getNotifications'); //ONLY ADMIN PAGE
    $router->post('page/answer-notification', 'PageController@answerNotification'); //ONLY ADMIN PAGE

});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('login', 'AuthController@login');
    $router->post('new-account', 'UserController@newAccount');

//    $router->post('/api/login', 'UserController@login');
//
//    $router->post('/api/user', 'UserController@store');
//    $router->get('/api/user/{id}', 'UserController@view');
//    $router->put('/api/user/{id}', 'UserController@update');
});



