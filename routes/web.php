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
$router->get('/user[/{id}]', ['uses'=>'UserController@index', 'as'=>'main']);
$router->get('/news', ['uses'=>'UserController@news', 'as'=>'news']);
$router->post('/message', ['uses'=>'UserController@message', 'as'=>'message']);
$router->post('/profile', ['uses'=>'UserController@profile', 'as'=>'profile']);
$router->post('/like', ['uses'=>'UserController@like', 'as'=>'like']);
$router->post('/get_news', ['uses'=>'UserController@get_news', 'as'=>'get_news']);
$router->post('/get_id', ['uses'=>'UserController@get_id', 'as'=>'id']);
$router->get('/chats', ['uses'=>'UserController@chats', 'as'=>'chats']);
$router->post('/get_chats', ['uses'=>'UserController@get_chats', 'as'=>'chats']);
$router->post('/get_messages', ['uses'=>'UserController@get_messages', 'as'=>'chats']);
