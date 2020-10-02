<?php

/**
 * @SWG\Swagger(schemes={"http"}, basePath="/v1", @SWG\Info(version="1.0.0", title="Api Exemplo API"))
 */

$router->get('/', function () use ($router) {
    print('It is working!');
});

$router->post('/api/login', 'AuthController@authenticate');

$router->group(['middleware' => 'jwt.auth', 'prefix' => 'api'], function () use ($router) {
    $router->get('refresh-token', 'AuthController@refresh');

    $router->get('clientes', 'ClienteController@index');
    $router->get('clientes/{id}', 'ClienteController@show');
    $router->post('clientes', 'ClienteController@store');
    $router->put('clientes/{id}', 'ClienteController@update');
    $router->delete('clientes/{id}', 'ClienteController@destroy');

    $router->get('pedidos', 'PedidoController@index');
    $router->get('pedidos/{id}', 'PedidoController@show');
    $router->post('pedidos', 'PedidoController@store');
    $router->put('pedidos/{id}', 'PedidoController@update');
    $router->delete('pedidos/{id}', 'PedidoController@destroy');
});