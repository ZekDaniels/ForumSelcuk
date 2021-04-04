<?php

use Illuminate\Support\Facades\Route;

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

///////////////////////////////////////////////////Default

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {

    ////////////////////////////////////////////////////////////Resources -- Restful API
    Route::resource('user', 'UserController');
    Route::resource('permission', 'PermissionController');
    Route::resource('forum', 'ThreadController');


    ///////////////////////////////////////////////////Get Post request Restful extras

    Route::get('/profile', 'UserController@profile')->name('user.profile');
    Route::post('/profile', 'UserController@postProfile')->name('user.postProfile');
    Route::get('/password/change', 'UserController@changePassword')->name('user.GetPassword');
    Route::patch('/password/change', 'UserController@PostPassword')->name('user.PostPassword');


    ///////////////////////////////////////////////////Ajax routes
    Route::get('/getUserModalData', 'UserController@getUserModalData');

});

///////////////////////////////////////////////////Restfull middleware

Route::group(['middleware' => ['auth','role_or_permission:Admin|create-role|create-permission']], function () {
    Route::resource('role', 'RoleController');
});
///////////////////////////////////////////////////Route Default Login-Register
Auth::routes();












//   ///////////////////////////////////////////////////Get data for create pages
//   Route::get('/getAllPermissions', 'PermissionController@getAllPermissions');
//   Route::get('/getAllRoles', 'PermissionController@getAllRoles');


//   Route::post('/postRole', 'RoleController@store');
