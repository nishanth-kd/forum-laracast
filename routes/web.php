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

Route::get('/threads/', 'ThreadsController@index');
Route::post('/threads/', 'ThreadsController@store');
Route::get('/threads/create/', 'ThreadsController@create');
Route::get('/threads/{channel}/{thread}/', 'ThreadsController@show');
Route::delete('/threads/{channel}/{thread}/', 'ThreadsController@destroy');
Route::get('/threads/{channel}/{thread}/edit', 'ThreadsController@edit');
Route::get('/threads/{channel}/{thread}/replies/', 'RepliesController@index');
Route::post('/threads/{channel}/{thread}/replies/', 'RepliesController@store');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('delete.reply');
Route::patch('/replies/{reply}', 'RepliesController@update');
Route::get('/threads/{channel}/', 'ThreadsController@index');
Route::post('favorite/reply/{reply}/', 'FavoritesController@favoriteReply')->name('favorite.reply');
Route::delete('favorite/reply/{reply}/', 'FavoritesController@unfavoriteReply')->name('favorite.reply');
Route::post('favorite/thread/{thread}/', 'FavoritesController@favoriteThread')->name('favorite.thread');
Route::delete('favorite/thread/{thread}/', 'FavoritesController@unfavoriteThread')->name('favorite.thread');
Route::get('profiles/{user}', 'ProfilesController@show')->name('profile');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
