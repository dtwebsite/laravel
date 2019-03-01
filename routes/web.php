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


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/', function () {
    return view('admin.index');
});

Route::get('/admin/dashboard', function () {
    return view('admin.index');
});

Route::get('/admin/member_list', function () {
    return view('admin.member_list');
});

Route::get('/admin/get_member_list',[
	'as' => 'get_member_list',
	'uses' => 'MemberController@get_member_list'
]);

Route::post('/admin/member_delete',[
	'as' => 'member_delete',
	'uses' => 'MemberController@member_delete'
]);

Route::post('/admin/member_edit',[
	'as' => 'member_edit',
	'uses' => 'MemberController@member_edit'
]);