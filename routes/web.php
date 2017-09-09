<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', function () {
    return view('welcome');
});

/*
Route::get('/login', function () {
    return view('auth.login');
});
*/

/*
Route::get('login',array('as'=>'login',function(){
    return view('auth.login');
}));
*/


//var_dump(get_class_methods(Auth)); die;

Route::get('/home', 'HomeController@index')->name('home');



//Auth::routes();



/*
Route::group(['middleware' => 'lang'], function()
{
    Route::controllers([ 'auth' => 'Auth\AuthController', 'password' => 'Auth\PasswordController', ]);
});
*/


/*
Route::get('register/{locale}', function ($locale) {
    App::setLocale($locale);

    //Auth::routes();
    //return redirect('register');

});
*/

/*
Route::get('/register', function () {
    return redirect('/' . App::getLocale(). '/login');
});
*/




/*

Route::get('users', 'UserController@index');

Route::get('user/{id}', 'UserController@getUserById');

Route::post('user/create', 'UserController@create');

Route::get('user/create', 'UserController@create');


Route::get('user/profile', function () {
    //
    return 'profile';
})->name('profile');


Route::get('photo/{id}', 'PhotoController@show');


Route::get('/home', 'HomeController@index')->name('home');
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
