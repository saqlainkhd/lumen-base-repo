<?php


use App\Http\Resources\SuccessResponse;

$router->group(['prefix' => 'v1','namespace' => 'V1'], function () use ($router) {
    $router->group(['prefix' => 'auth', 'middleware' => 'client_credendials'], function () use ($router) {
        $router->post('/login', 'AuthController@login');
    });

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->group(['prefix' => 'customers'], function () use ($router) {
            $router->get('/', 'CustomerController@index');
            $router->post('/', 'CustomerController@create');
            $router->put('/{id}', 'CustomerController@update');
            $router->get('/{id}', 'CustomerController@show');
            $router->delete('/{id}', 'CustomerController@destory');
        });
    });
});
