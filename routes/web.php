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

Route::get('/index', function () {
    return View::make('index');
});

Route::get('/ang_index', function () {
    return View::make('ang_index');
});
Route::get('404',['as'=>'404','uses'=>'ErrorHandlerController@errorCode404']);
Route::get('home',['as'=>'home.index','uses'=>'HomeController@index']);

Route::resource('product', 'ProductController');
Route::resource('category', 'CategoryController');
