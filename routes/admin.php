<?php

Route::get('/home','AdminController@index')->name('home')->middleware('admin');
Route::get('/', 'AdminController@index')->name('home')->middleware('admin');

