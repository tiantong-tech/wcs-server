<?php

Route::get('/', 'AppController@home');
Route::get('/api', 'AppController@home');

Route::post('/hoisters/list', 'HoisterController@list');
Route::post('/hoisters/list/all', 'HoisterController@listAll');
Route::post('/hoisters/detail', 'HoisterController@getDetail');
Route::post('/hoisters/create', 'HoisterController@createHoister');
Route::post('/hoisters/update', 'HoisterController@updateHoister');
Route::post('/hoisters/delete', 'HoisterController@deleteHoister');
Route::post('/hoisters/floors/create', 'HoisterController@createFloor');
Route::post('/hoisters/floors/delete', 'HoisterController@deleteFloor');

Route::post('/plcs/test', 'PlcController@test');
Route::post('/plcs/state', 'PlcController@getState');
Route::post('/plcs/dispatch', 'PlcController@testDispatch');
