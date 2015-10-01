<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function() { 
Route::get('/dashboard', 'backend\AdminDashboard@listDashboard');
/* User */
Route::get('user', function () {
	 return Redirect::to('/user/listUser');
});
Route::get('/user/addUser', 'backend\AdminUser@addUser');
Route::post('/user/storeUser', 'backend\AdminUser@storeUser');
Route::get('/user/listUser', 'backend\AdminUser@listUser');
Route::post('/user/listUser', 'backend\AdminUser@listUser');
Route::get('/user/editUser/{usrid}', 'backend\AdminUser@editUser');
Route::post('/user/updateUser/', 'backend\AdminUser@updateUser');
Route::get('/user/logoutUser', 'backend\AdminUser@logoutUser');
/* Category */
Route::get('/cat/editCat/{catid}', 'backend\AdminCat@editCat');
Route::get('/cat/addCat', 'backend\AdminCat@addCat');
Route::get('/cat/listCat', 'backend\AdminCat@listCat');
Route::post('/cat/storeCat', 'backend\AdminCat@storeCat');
Route::get('/cat/delCat/{catid}', 'backend\AdminCat@delCat');
Route::post('/cat/updateCat', 'backend\AdminCat@updateCat');
Route::get('cat', function () {
	 return Redirect::to('/cat/listCat');
});
/* Article*/
Route::get('/art/editArt/{artid}', 'backend\AdminArt@editArt');
Route::get('/art/addArt', 'backend\AdminArt@addArt');
Route::get('/art/listArt', 'backend\AdminArt@listArt');
Route::post('/art/storeArt', 'backend\AdminArt@storeArt');
Route::get('/art/delArt/{artid}', 'backend\AdminArt@delArt');
Route::post('/art/updateArt', 'backend\AdminArt@updateArt');
Route::get('art', function () {
	 return Redirect::to('/art/listArt');
});
/* Status*/
Route::get('/status/editStatus/{code}', 'backend\AdminStatus@editStatus');
Route::get('/status/addStatus', 'backend\AdminStatus@addStatus');
Route::get('/status/listStatus', 'backend\AdminStatus@listStatus');
Route::post('/status/storeStatus', 'backend\AdminStatus@storeStatus');
Route::get('/status/delStatus/{code}', 'backend\AdminStatus@delStatus');
Route::post('/status/updateStatus', 'backend\AdminStatus@updateStatus');
Route::get('status', function () {
	 return Redirect::to('/status/listStatus');
});
/* Gallery*/
Route::get('/gallery/editGallery/{id_gallery}', 'backend\AdminGallery@editGallery');
Route::get('/gallery/addGallery', 'backend\AdminGallery@addGallery');
Route::get('/gallery/listGallery', 'backend\AdminGallery@listGallery');
Route::post('/gallery/storeGallery', 'backend\AdminGallery@storeGallery');
Route::get('/gallery/delGallery/{id_gallery}', 'backend\AdminGallery@delGallery');
Route::post('/gallery/updateGallery', 'backend\AdminGallery@updateGallery');
Route::get('gallery', function () {
	 return Redirect::to('/gallery/listGallery');
});
Route::get('/gallery/addPhoto/{id_gallery}', 'backend\AdminGallery@addPhoto');
Route::get('/gallery/editPhoto/{id_gallery}/{id_item}', 'backend\AdminGallery@editPhoto');
Route::post('/gallery/updatePhoto', 'backend\AdminGallery@updatePhoto');
Route::get('/gallery/delPhoto/{id_gallery}/{id_item}', 'backend\AdminGallery@delPhoto');
Route::post('/gallery/storePhoto', 'backend\AdminGallery@storePhoto');
/* Upload file*/
Route::post('/upload/storeFile/', 'backend\AdminFile@storeFile');
Route::get('/upload/listFile/', 'backend\AdminFile@listFile');
Route::get('/upload/delFile/{files}', 'backend\AdminFile@delFile');
Route::get('upload', function () {
	 return Redirect::to('/upload/listFile');
});

});
Route::post('/user/authUser', 'backend\AdminUser@authUser');
Route::get('/user/loginUser', 'backend\AdminUser@loginUser');

Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('home', function () {
	 return Redirect::to('/user/loginUser');
});

