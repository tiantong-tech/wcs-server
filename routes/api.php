<?php

Route::get('/', 'AppController@home');
Route::get('/api', 'AppController@home');

Route::post('/plc/search', 'PlcController@search');
