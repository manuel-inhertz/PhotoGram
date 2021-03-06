<?php
use App\User;

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

// Home Route

Route::get('/', 'PostsController@index');

// Posts Routes

Route::get('/p/create', 'PostsController@create');

Route::post('/p', 'PostsController@store');

Route::get('/p/{post}', 'PostsController@show');

// Profile Routes

Route::get('/profile/{username}', 'ProfilesController@index')->name('profile.show');

Route::get('/profile/{username}/edit', 'ProfilesController@edit')->name('profile.edit');

Route::patch('/profile/{username}', 'ProfilesController@update')->name('profile.update');

// Follow Routes
Route::post('follow/{user}', 'FollowsController@store');

// Like Routes
Route::post('like/{post}', 'PostsController@like');

// Comments Routes
Route::post('comment/{post}', 'PostsController@comment');

Route::get('comments/{post}', 'PostsController@getComments');