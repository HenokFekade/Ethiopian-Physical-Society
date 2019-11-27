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

Route::resource('fields', 'FieldController');

Route::post('fields/all', 'FieldController@fields');

Route::resource('users', 'UserController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


View::composer(['welcome', 'admin.user.create', 'admin.user.edit'], function ($view) {
    $fields = App\Field::orderBy('name', 'ASC')->get();
    $view->with('fields', $fields);
});