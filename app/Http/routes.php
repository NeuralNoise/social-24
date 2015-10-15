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
    'as' => 'auth.signup',
    'middleware' => ['guest'] // here 'guest' is beign called from Kernel.php
]);

Route::post('/signup', [
    'uses' => '\Chatty\Http\Controllers\AuthController@postSignup',
    'middleware' => ['guest'] // here 'guest' is beign called from Kernel.php
]);

/**
 * Sign in
 */

Route::get('/signin', [
    'uses' => '\Chatty\Http\Controllers\AuthController@getSignin',
    'as' => 'auth.signin',
    'middleware' => ['guest'] // here 'guest' is beign called from Kernel.php
]);

Route::post('/signin', [
    'uses' => '\Chatty\Http\Controllers\AuthController@postSignin',
    'middleware' => ['guest'] // here 'guest' is beign called from Kernel.php
]);

/**
 * Sign out
 */

Route::get('/signout', [
    'uses' => '\Chatty\Http\Controllers\AuthController@getSignout',
    'as' => 'auth.signout'
]);
