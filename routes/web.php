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

Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');
    Route::get('/stafflist','AdminController@StaffList')->name('stafflist');
    Route::post('/cook/change-status','AdminController@ChangeStatusCook')->name('cook.changestatus');
    Route::post('/employe/change-status','AdminController@ChangeStatusEmploye')->name('employe.changestatus');
    Route::post('/cook/update','AdminController@UpdateCooks')->name('cook.update');
    Route::post('/addstaff','StaffController@AddStaff')->name('addStaff');
    Route::post('/delstaff/{id}','StaffController@delete');
    Route::get('/menu','AdminController@menuforadmin');
    Route::get('/emplist','EmployeeController@index')->name('emplist');
    Route::post('/emplist/store','AdminController@AddEmploye')->name('addEmploye');
    Route::post('/update_employe','AdminController@UpdateEmploye');
    Route::post('/delemp/{id}','EmployeeController@delete');
Route::get('/orders','AdminController@orders');
    Route::get('/orderbyitem','AdminController@ordersbyitem');
    Route::get('/oldermenus','AdminController@oldermenu');
  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'employee'], function () {
  Route::get('/login', 'EmployeeAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'EmployeeAuth\LoginController@login');
  Route::post('/logout', 'EmployeeAuth\LoginController@logout')->name('logout');
  Route::post('/password/email', 'EmployeeAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'EmployeeAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'EmployeeAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'EmployeeAuth\ResetPasswordController@showResetForm');
  Route::get('/orderlunch','OrderController@createorder');
  Route::get('/notifications','OrderController@ordenotify');
  Route::post('/storeorder','OrderController@storeorder');
});

Route::group(['prefix' => 'cook'], function () {
  Route::get('/login', 'CookAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'CookAuth\LoginController@login');
  Route::post('/logout', 'CookAuth\LoginController@logout')->name('logout');
  Route::post('/password/email', 'CookAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'CookAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'CookAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'CookAuth\ResetPasswordController@showResetForm');
  Route::post('/additem','MenuController@storeitems')->name('storeitems');
 Route::get('/items','MenuController@items');

  Route::get('/addmenu','MenuController@create')->name('createmenu');
    Route::post('/addmenu/save','MenuController@store')->name('storemenu');
    Route::get('/editmenu/{id}','MenuController@edit')->name('editmenu');
    Route::post('/orderdone','OrderController@orderdone')->name('o');
    Route::post('/updatemenu','MenuController@update')->name('updatemenu');
    Route::post('/edititem','MenuController@updateItem')->name('updateitem');



});
