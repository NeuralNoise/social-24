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

/**
 * Sign in
 */

Route::get('/signin', [
    'uses' => '\Chatty\Http\Controllers\AuthController@getSignin',
    'as' => 'auth.signin'
]);

Route::post('/signin', [
    'uses' => '\Chatty\Http\Controllers\AuthController@postSignin',
]);

/**
 * Sign out
 */

Route::get('/signout', [
    'uses' => '\Chatty\Http\Controllers\AuthController@getSignout',
    'as' => 'auth.signout'
]);
