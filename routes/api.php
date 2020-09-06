<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('orders', 'WorkOrderController@index')->middleware(['return.json','auth:api']);
Route::post('orders/store', 'WorkOrderController@store')->middleware(['return.json','auth:api']);
Route::post('orders/sendEmail/{id}', 'WorkOrderController@sendEmail');

/*Route::middleware(['return.json','auth:api']) // Use our JSON Middleware
    ->group(function () {
        Route::get('orders', 'WorkOrderController@index');
    });*/
