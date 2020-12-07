<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post(
        'register',
        [
            'uses' => 'API\Auth\RegisterController@register',
            'as' => 'register'
        ]
    );
    Route::post(
        'login',
        [
            'uses' => 'API\Auth\LoginController@login',
            'as' => 'login'
        ]
    );
});

Route::prefix('user')->group(function (){
    Route::get(
        '',
        [
            'uses' => 'API\UserController@index',
            'as' => 'users-list'
        ]
    );
    Route::get(
        'profile/{id}',
        [
            'uses' => 'API\UserController@show',
            'as' => 'profile'
        ]
    );
    Route::post(
        'logout',
        [
            'uses' => 'API\Auth\LogoutController@logout',
            'as' => 'logout'
        ]
    );
    Route::post(
        'delete',
        [
            'uses' => 'API\UserController@destroy',
            'as' => 'delete'
        ]
    );
});

Route::prefix('test')->middleware('auth:api')->group(function () {
    Route::get(
        '',
        [
            'uses' => 'API\MatrialController@index',
            'as' => 'test'
        ]
    );
    Route::get(
        '{matrial_id}/{chapter_id}/quetions',
        [
            'uses' => 'API\QuetionController@quetions',
            'as' => 'quetions'
        ]
    );
    Route::get(
        'statement/',
        [
            'uses' => 'API\TestController@index',
            'as' => 'statment'
        ]
    );
    Route::post(
        'statement/create',
        [
            'uses' => 'API\TestController@store',
            'as' => 'statment-create'
        ]
    );
    Route::delete(
        'statement/clear',
        [
            'uses' => 'API\TestController@destroy',
            'as' => 'statment-delete'
        ]
    );
    Route::get(
        'statement/{id}/',
        [
            'uses' => 'API\TestController@show',
            'as' => 'statment-show'
        ]
    );
    Route::put(
        'statement/{id}/',
        [
            'uses' => 'API\TestController@update',
            'as' => 'statment-update'
        ]
    );
});

Route::prefix('challenge')->middleware('auth:api')->group(function ()
{
    Route::get(
        'sended/',
        [
            'uses' => 'API\ChallengeController@sendedChallenges',
            'as' => 'challenges'
        ]
    );
    Route::get(
        'recived/',
        [
            'uses' => 'API\ChallengeController@recivedChallenges',
            'as' => 'challenges'
        ]
    );
    Route::post(
        'create/',
        [
            'uses' => 'API\ChallengeController@store',
            'as' => 'challenge-create'
        ]
    );
    Route::get(
        '{id}/',
        [
            'uses' => 'API\ChallengeController@show',
            'as' => 'challenge-show'
        ]
    );
    Route::put(
        '{id}/',
        [
            'uses' => 'API\ChallengeController@update',
            'as' => 'challenge-update'
        ]
    );

});