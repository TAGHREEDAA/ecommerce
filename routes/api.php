<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(array('prefix' => 'v1'), function()
{

    Route::get('products',['as'=>'api.v1.product.index','uses'=> 'ApiControllers\ProductApiController@index']);
    Route::get('products/{id?}', ['as'=>'api.v1.product.show','uses'=>'ApiControllers\ProductApiController@show']);

    Route::resource('api.v1.category', 'ApiControllers\CategoryApiController',
        array('only' => array('index','show', 'store', 'destroy')));

});