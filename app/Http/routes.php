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


/**
 * Search
 */

Route::get('/search', [
    'uses' => '\Chatty\Http\Controllers\SearchController@getResults',
    'as' => 'search.results',
]);


/**
 * User profile
 */

Route::get('/user/{username}', [
    'uses' => '\Chatty\Http\Controllers\ProfileController@getProfile',
    'as' => 'profile.index',
]);


/**
 * Update profile
 */


Route::get('/profile/edit', [
    'uses' => '\Chatty\Http\Controllers\ProfileController@getEdit',
    'as' => 'profile.edit',
    'middleware' => ['auth'] // here 'auth' is beign called from Kernel.php
]);

Route::post('/profile/edit', [
    'uses' => '\Chatty\Http\Controllers\ProfileController@postEdit',
]);


/**
 * Friends
 */

Route::get('/friends', [
    'uses' => '\Chatty\Http\Controllers\FriendController@getIndex',
    'as' => 'friend.index',
    'middleware' => ['auth'] // here 'auth' is beign called from Kernel.php
]);
