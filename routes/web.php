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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');
Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');
Route::post('/threads/store', 'ThreadsController@store')->name('threads.store');

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store')->name('replies.store');
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index')->name('replies.index');

Route::post('/threads/{channel}/{thread}/subscribe', 'SubscribeThreadsController@store')->name('replies.store');
Route::delete('/threads/{channel}/{thread}/subscribe', 'SubscribeThreadsController@destroy')->name('replies.store');


Route::get('/threads/{channel}', 'ThreadsController@index')->name('threads.index');
Route::get('/threads', 'ThreadsController@index')->name('threads.index');
Route::delete('/threads/{thread}', 'ThreadsController@destroy')->name('threads.destroy');

Route::post('/favorites/{reply}', 'FavoritesController@store')->name('replies.favorites.store');
Route::delete('/favorites/{reply}', 'FavoritesController@destroy')->name('replies.favorites.store');

Route::patch('/replies/{reply}', 'RepliesController@update')->name('replies.update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.delete');

Route::get('/profiles/notifications', 'NotificationsController@index')->name('notifications.index');
Route::delete('/profiles/notifications/{notifications}', 'NotificationsController@destroy')->name('notifications.delete');
Route::get('/profiles/{user}', 'ProfilesController@show')->name('profiles.show');


Route::get('/api/users/', 'Api\UsersController@index')->name('api_users.index');






