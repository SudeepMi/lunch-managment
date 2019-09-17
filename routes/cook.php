<?php

Route::get('/home','StaffController@home')->name('home');

Route::get('/','StaffController@home')->name('home');

