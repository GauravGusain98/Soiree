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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get("/soiree", "AdminController@showHome");
Route::post("/logout", "AdminController@logout");

Route::get("/admin","AdminController@login");

Route::post("/admin","AdminController@register");


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/home', function(){
    return view('homepage');
});
