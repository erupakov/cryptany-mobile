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

Route::get('/', 'CGWController@index');
Route::get('/legacy', 'CGWController@indexLegacy');
Route::get('/transit', 'CGWController@index');
Route::post('/transit', 'CGWController@confirm');
Route::get('/transit/{id}', 'CGWController@showTransaction')->name('showTransaction');
Route::get('/faq', 'CGWController@faq');
Route::get('/updateStatus18640', 'CGWController@showUpdateStatusPage');
Route::post('/updateStatus18640', 'CGWController@processUpdateStatus');
