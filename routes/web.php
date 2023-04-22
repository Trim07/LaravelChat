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
Route::post('create-chat', 'ChatsController@fetchMessages')->name('create-chat');
Route::get('chats', 'ChatsController@fetchChats')->name('chats');
Route::get('messages', 'ChatsController@fetchMessages');
Route::post('messages', 'ChatsController@sendMessage');
Route::get('get-users', 'HomeController@getUsers');

