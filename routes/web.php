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
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('/home', 'HomeController@index')->name('home');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/dashboard',[
	'as' => 'dashboard',
	'uses' => 'Controller@admin_index'
]);

Route::get('/admin/member_list',[
	'as' => 'member_list',
	'uses' => 'MemberController@index'
]);

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

Route::get('/admin/news_list',[
	'as' => 'news_list',
	'uses' => 'NewsController@index'
]);

Route::get('/admin/get_news_list',[
	'as' => 'get_news_list',
	'uses' => 'NewsController@get_news_list'
]);

Route::post('/admin/insert_news',[
	'as' => 'insert_news',
	'uses' => 'NewsController@insert_news'
]);

Route::post('/admin/get_edit_data',[
	'as' => 'get_edit_data',
	'uses' => 'NewsController@get_edit_data'
]);

Route::post('/admin/news_edit',[
	'as' => 'news_edit',
	'uses' => 'NewsController@news_edit'
]);

Route::post('/admin/news_delete',[
	'as' => 'news_delete',
	'uses' => 'NewsController@news_delete'
]);

Route::get('/admin/commodity_category',[
	'as' => 'commodity_category',
	'uses' => 'CommodityController@category_index'
]);

Route::get('/admin/get_commodity_category',[
	'as' => 'get_commodity_category',
	'uses' => 'CommodityController@get_commodity_category'
]);

Route::post('/admin/insert_commodity_category',[
	'as' => 'insert_commodity_category',
	'uses' => 'CommodityController@insert_commodity_category'
]);

Route::post('/admin/edit_commodity_category',[
	'as' => 'edit_commodity_category',
	'uses' => 'CommodityController@edit_commodity_category'
]);

Route::post('/admin/commodity_category_delete',[
	'as' => 'commodity_category_delete',
	'uses' => 'CommodityController@commodity_category_delete'
]);

Route::get('/admin/commodity_list',[
	'as' => 'commodity_list',
	'uses' => 'CommodityController@list_index'
]);

Route::get('/admin/get_commodity_list',[
	'as' => 'get_commodity_list',
	'uses' => 'CommodityController@get_commodity_list'
]);

Route::post('/admin/insert_commodity',[
	'as' => 'insert_commodity',
	'uses' => 'CommodityController@insert_commodity'
]);