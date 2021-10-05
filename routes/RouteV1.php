<?php


use App\Http\Resources\SuccessResponse;

$router->group(['prefix' => 'v1','namespace' => 'V1'], function () use ($router) {
    $router->group(['prefix' => 'auth', 'middleware' => 'client_credendials'], function () use ($router) {
        $router->post('/login', 'AuthController@login');
    });
});
