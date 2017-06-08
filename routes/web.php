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

$app->get('/', function () use ($app) {
    return $app->version();
});
$app->post('jugador/perfil/show', 'PerfilController@show');
$app->post('jugador/perfil/update', 'PerfilController@update');

$app->post('user/create', 'LoginController@create');
$app->post('user/login', 'LoginController@index');

$app->post('partida/create', 'PartidaController@create');
$app->post('partida/show', 'PartidaController@index');

