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

Route::get('/', 'HomepageController@index')->name('homepage.index');
Route::post('/', 'HomepageController@store')->name('homepage.store');
Route::post('/login', 'HomepageController@login')->name('homepage.login');
Route::get('/logout', 'HomepageController@logout')->name('homepage.logout');

Route::prefix('/groups')->group(function() {
	Route::prefix('/{group_id}')->group(function($groupId) {
		Route::get('/', 'GroupController@index')
			->name('groups.index');
		Route::get('/posts/{post_id}', 'GroupController@getPost')
			->name('groups.post');
		Route::get('/members', 'GroupController@getMembers')
			->name('groups.members');
	});
});

Route::prefix('/profile/{slug}')->group(function($slug) {
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

Route::prefix('/settings')->group(function() {
	Route::get('/', 'SettingController@index')
		->name('settings.index');
	Route::get('/password', 'SettingController@password')
		->name('settings.password');
	Route::get('/privacy', 'SettingController@privacy')
		->name('settings.privacy');
});