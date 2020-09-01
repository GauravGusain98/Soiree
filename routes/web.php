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

Route::post("/adminverify", "AdminController@verify")->name('verify');

Route::post("/guest/login","GuestController@login")->name("guest_login");
Route::get("/guest/login","GuestController@index");

Route::get("/adminpage", "AdminController@showHome");
Route::post("/adminlogout", "AdminController@logout");
Route::post("/guestlogout", "GuestController@logout");

Route::get("/admin","AdminController@login");
Route::post("/admin","AdminController@register");


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/home', function(){
    return view('adminHomepage');
});

Route::get('/guest/home', function(){
    return view('guestHomepage');
});

Route::get("/admin/registered",function(){
    return view("registered_success");
});

Route::post("/requests", "AdminHomepageController@showRequests");
Route::post("/guests", "AdminHomepageController@showGuests");
Route::post("/status", "AdminHomepageController@status");
Route::post("/cancelled", "AdminHomepageController@showCancelledRequests");
Route::post("/changestatus", "AdminHomepageController@changeStatus");
Route::post("/addfunction", "EventController@addFunction");
Route::post("/showfunction", "EventController@showFunction");
Route::post("/savefunction","EventController@saveFunction")->name('saveedit');
Route::post("/deletefunction","EventController@deleteFunction")->name('deleteFunction');