<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::post('/accept','WorkOrderController@acceptOrder')->name('accept.order');
Route::get('/cancel/{id}','WorkOrderController@cancelOrder')->name('cancel.order');

/*upload file screen*/
Route::get('/uploadFile', 'ProcessFileController@index')->name('upload');
/*prcoess the file*/
Route::post('/processFile', 'ProcessFileController@process');
