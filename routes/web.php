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

$router->get('/',['as'=>'home','uses'=>'IndexController@show']);
$router->get('/json', 'IndexController@getJSON');
$router->post('/register', ['uses'=>'IndexController@register', 'as'=>'register', 'middleware'=>'register']);
$router->post('/login', ['uses'=>'IndexController@login', 'as'=>'login', 'middleware'=>'login']);
$router->get('/logout', 'UserController@logout');
$router->get('/activate/{url_activate}', ['uses'=>'IndexController@activate', 'as'=>'activate']);
$router->get('/user', ['uses'=>'UserController@index', 'as'=>'main']);

