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

Auth::routes();

Route::get('/', 'ChatsController@index');
Route::post('create-conversation', 'ChatsController@createConversation')->name('create-conversations');
Route::get('conversations', 'ChatsController@fetchConversations')->name('fetch-conversations');
Route::get('messages', 'ChatsController@fetchMessages');
Route::post('messages', 'ChatsController@sendMessage');
Route::get('get-users', 'HomeController@getUsers');

