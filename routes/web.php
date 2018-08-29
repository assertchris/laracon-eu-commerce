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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('/', 'welcome');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/subscribe', 'UsersController@showSubscribe')
        ->name('users.showSubscribe');

    Route::post('/subscribe/{token}', 'UsersController@doSubscribe')
        ->name('users.doSubscribe');
});