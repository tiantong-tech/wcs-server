<?php

Route::get('/', 'AppController@home');
Route::get('/api', 'AppController@home');

Route::post('/plc/search', 'PlcController@search');

Route::post('/hoisters/list', 'HoisterController@list');
Route::post('/hoisters/detail', 'HoisterController@getDetail');
Route::post('/hoisters/create', 'HoisterController@createHoister');
Route::post('/hoisters/update', 'HoisterController@updateHoister');
Route::post('/hoisters/delete', 'HoisterController@deleteHoister');
Route::post('/hoisters/floors/create', 'HoisterController@createFloor');
Route::post('/hoisters/floors/delete', 'HoisterController@deleteFloor');
