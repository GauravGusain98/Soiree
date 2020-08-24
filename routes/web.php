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

Route::get("/soiree", "SoireeController@showHome");
Route::post("/logout", "SoireeController@logout");

Route::get("/admin","SoireeController@login");

Route::post("/admin","SoireeController@register");


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/home', function(){
    return view('homepage');
});
