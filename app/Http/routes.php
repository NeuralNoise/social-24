<?php

/**
 * Home
 */

Route::get('/', [
    'uses' => '\Chatty\Http\Controllers\HomeController@index',
    'as' => 'home'
]);


/**
 * Authentication
 */

Route::get('/signup', [
    'uses' => '\Chatty\Http\Controllers\AuthController@getSignup',
    'as' => 'auth.signup'
]);

Route::post('/signup', [
    'uses' => '\Chatty\Http\Controllers\AuthController@postSignup',
]);