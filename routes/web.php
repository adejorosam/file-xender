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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::resource('/files', 'DocumentController');
Route::get('dashboard', 'DashboardController@dashboard');
Route::post('/profile', 'DashboardController@update');
Route::get('/profile', 'DashboardController@profile');
Route::get('download/{id}', 'DocumentController@filedownload');

