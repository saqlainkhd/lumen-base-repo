<?php


use App\Http\Resources\SuccessResponse;

$router->group(['prefix' => 'v1','namespace' => 'V1'], function () use ($router) {
    $router->group(['prefix' => 'auth', 'middleware' => 'client_credendials'], function () use ($router) {
        $router->post('/login', 'AuthController@login');
    });

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->group(['prefix' => 'customers'], function () use ($router) {
            $router->get('/', 'CustomerController@index');
            $router->get('/search', 'CustomerController@search');
            $router->get('/{id}', 'CustomerController@show');
            $router->post('/', 'CustomerController@create');
            $router->put('/{id}', 'CustomerController@update');
            $router->delete('/{id}', 'CustomerController@destory');
        });

        

        $router->group(['prefix' => 'members'], function () use ($router) {
            $router->get('/', 'MemberController@index');
            $router->get('/search', 'MemberController@search');
            $router->get('/{id}', 'MemberController@show');
            $router->post('/', 'MemberController@create');
            $router->put('/{id}', 'MemberController@update');
            $router->delete('/{id}', 'MemberController@destory');
        });
    });
});
