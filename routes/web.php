<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'UserController@showLogin')->name('login');
Route::get('/login', 'UserController@showLogin')->name('login');
Route::post('/login', 'UserController@login')->name('login');
Route::post('/logout', 'UserController@logout')->name('logout');

// Route collection for user module
require_once base_path('routes/modules/calendar.php');
// Route collection for user module
require_once base_path('routes/modules/event.php');