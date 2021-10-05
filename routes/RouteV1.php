<?php


use App\Http\Resources\SuccessResponse;

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->post('/auth/login', function () use ($router) {
        return new SuccessResponse([]);
    });
});
