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

Route::resource('fields', 'FieldController')->middleware('verified');

Route::post('fields/get', 'FieldController@returnAllFields')->middleware('verified');

Route::resource('users', 'UserController')->middleware('verified');

Route::get('users/account-activate/{user}', 'UserController@activateAccount')->middleware('verified');

Route::get('users/account-deactivate/{user}', 'UserController@deactivateAccount')->middleware('verified');

Route::post('users/get-all-users', 'UserController@returnAllUsers')->middleware('verified');

Route::get('account/edit', 'AccountController@edit')->middleware('verified');

Route::post('account', 'AccountController@update')->middleware('verified');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');


View::composer(['welcome', 'admin.user.create', 'admin.user.edit'], function ($view) {
    $fields = App\Field::orderBy('name', 'ASC')->get();
    $view->with('fields', $fields);
});
