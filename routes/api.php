<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function() {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/add', 'ExpenseController@add');
    
    Route::post('/get', 'ExpenseController@get');

});

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/users/{user}', function (App\User $user) {
    return $user->email;
});
*/

/*
Route::get('test', function () {
    print_r('Hello world');
});
*/

/*
Route::group(array('prefix' => 'api/v1/expense'), function()
{
    //Route::resource('pages', 'PagesController', array('only' => array('index', 'store', 'show', 'update', 'destroy')));
    //Route::resource('users', 'UsersController');
    Route::resource('add', 'ExpenseController', array('only' => array('add')));
});
*/

/*
Route::post('add', 'ExpenseController@add');

Route::get('get/{option}/{value}', 'ExpenseController@get');
*/
