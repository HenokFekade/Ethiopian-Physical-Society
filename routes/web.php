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

Route::get('account/account-activate/{user}', 'AccountController@activateAccount')->middleware('verified');

Route::get('account/account-deactivate/{user}', 'AccountController@deactivateAccount')->middleware('verified');

Route::post('users/get-all-users', 'UserController@returnAllUsers')->middleware('verified');

Route::get('account/edit', 'AccountController@edit')->middleware('verified');

Route::post('account', 'AccountController@update')->middleware('verified');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::post('files', 'FileController@store');

Route::get('file/download/{file}', 'FileController@download')->middleware('verified');

Route::get('file/reply/{file}', 'FileController@createReply')->middleware('verified');

Route::put('file/reply/{file}', 'FileController@storeReply')->middleware('verified');

Route::get('file/reject/{file}', 'FileController@rejectFile')->middleware('verified');

View::composer(['welcome', 'admin.user.create', 'admin.user.edit'], function ($view) {
    $fields = App\Field::orderBy('name', 'ASC')->get();
    $view->with('fields', $fields);
});
