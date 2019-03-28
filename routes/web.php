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

Route::get('threads', 'ThreadController@index');
Route::get('threads/create', 'ThreadController@create');
Route::get('threads/{channel}/{thread}', 'ThreadController@show');
Route::get('threads/{channel}', 'ThreadController@index');
Route::post('threads', 'ThreadController@store');

//Replies on a thread
Route::post('threads/{channel}/{thread}/replies', 'ReplyController@store');

//favourites on replies
Route::post('replies/{reply}/favourites', 'FavouriteController@store');
