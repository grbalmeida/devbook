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

Route::prefix('/groups')->group(function() {
	Route::get('/{group_id}', 'GroupController@index')
		->name('groups.index');
	Route::get('/{group_id}/posts/{post_id}', 'GroupController@getPost')
		->name('groups.post');
	Route::get('/{group_id}/members', 'GroupController@getMembers')
		->name('groups.members');
});