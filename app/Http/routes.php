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
use App\Entity\Member;
use App\Entity\Category;

 
Route::get('/login','View\MemberController@toLogin');
Route::get('/register','View\MemberController@toRegister');
Route::get('/category', 'View\BookController@toCategory');
Route::get('/product/category_id/{category_id}', 'View\BookController@toProduct');
Route::get('/pdtcontent/product_id/{product_id}', 'View\BookController@toPdtContent');
Route::get('/addCart/product_id/{product_id}', 'Service\CartController@addCart');
Route::get('/cart', 'View\CartController@toCart');


Route::post('/getCategory', 'Service\BookController@getCategory');
Route::post('/getProduct', 'Service\BookController@getProduct');
// Route::post('/getContent', 'Service\BookController@getContent');



Route::group(['prefix'=>'service'], function(){
	Route::get('validate_code/create', 'Service\ValidateController@create');
	Route::get('validate_phone/send/{phone}', 'Service\ValidateController@sendSMS');
	Route::any('validate_email/{member_id}/{code}', 'Service\ValidateController@validateEmail');
	Route::any('register', 'Service\MemberController@register');
	Route::post('login', 'Service\MemberController@login');
});
