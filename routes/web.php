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

Route::prefix('/{slug}')->group(function($slug) {
	Route::get('/', 'ProfileController@index')
		->name('profile.index');
	Route::get('/about', 'ProfileController@getAbout')
		->name('profile.about');
	Route::get('/friends', 'ProfileController@getFriends')
		->name('profile.friends');
	Route::get('/groups', 'ProfileController@getGroups')
		->name('profile.groups');
	Route::get('/posts/{post_id}', 'ProfileController@getPostById')
		->name('profile.post');
	Route::get('/photos', 'ProfileController@getPhotos')
		->name('profile.photos');
});	