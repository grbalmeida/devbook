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


Route::put('/about/biography', 'ProfileController@changeBiography')
	->name('profile.update-biography');
Route::put('/about/relationship_status', 'ProfileController@changeRelationshipStatus')
	->name('profile.update-relationship-status');
Route::put('/about/cities', 'ProfileController@changeCities')
	->name('profile.cities');
Route::put('/about/word-education', 'ProfileController@changeWorkAndEducation')
	->name('profile.work-education');

Route::prefix('/settings')->group(function() {
	Route::get('/', 'SettingController@index')
		->name('settings.index');
	Route::put('/', 'SettingController@updatePersonalInformation')
		->name('settings.updatePersonalInformation');
	Route::get('/password', 'SettingController@password')
		->name('settings.password');
	Route::put('/password', 'SettingController@updatePassword')
		->name('settings.updatePassword');
	Route::get('/privacy', 'SettingController@privacy')
		->name('settings.privacy');
	Route::put('/privacy', 'SettingController@updatePrivacy')
		->name('settings.updatePrivacy');
});

Route::post('/add-friend/{requestedUserId}', 'Ajax\AddFriendController@store')
	->name('add-friend');
Route::post('/remove-friend-request/{requestUserId}', 'Ajax\AddFriendController@destroy')
	->name('remove-friend-request');
Route::post('/accept-friend-request/{requestUserId}', 'Ajax\AddFriendController@addFriend')
	->name('accept-friend-request');

Route::post('add-post/{post}', 'UserPostController@store');
Route::post('add-remove-like/{postId}', 'UserPostLikeController@addRemoveLike');
Route::post('add-comment/{postId}/{comment}', 'UserPostCommentController@store');
Route::delete('undo-friendship/{requestedId}', 'Ajax\AddFriendController@removeFriendship');

Route::get('search-users/{user}', 'UserController@getUsersByName');