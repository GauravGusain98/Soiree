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

Route::post("/adminverify", "AdminController@verify")->name('admin-verify');

Route::post("/guest/login", "GuestController@login")->name("guest_login");
Route::get("/guest/login", "GuestController@index")->name("guest-login");

Route::get("/adminpage", "AdminController@showHome")->name("admin-page");
Route::post("/adminlogout", "AdminController@logout")->name("admin-logout");
Route::post("/guestlogout", "GuestController@logout")->name("guest-logout");

Route::get("/admin", "AdminController@login")->name("admin-login");
Route::post("/admin", "AdminController@register")->name("admin-registration");


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/home', function () {
    return view('adminHomepage');
})->name("admin-home")->middleware("AdminMiddleware");

Route::get('/guest/home', function () {
    return view('guestHomepage');
})->name('guest-homepage')->middleware("GuestMiddleware");

Route::get("/admin/registered", function () {
    return view("registered_success");
})->name('admin-registered')->middleware("verificationPageMiddleware");

Route::post("/requests", "AdminHomepageController@showRequests")->name("guest-requests");
Route::post("/guests", "AdminHomepageController@showGuests")->name("verified-guests");
Route::post("/status", "AdminHomepageController@status")->name('status');
Route::post("/cancelled", "AdminHomepageController@showCancelledRequests")->name('cancelled-request');
Route::post("/changestatus", "AdminHomepageController@changeStatus")->name('change-status');
Route::post("/addfunction", "EventController@addFunction")->name('add-function');
Route::post("/showfunction", "EventController@showFunction")->name('show-function');
Route::post("/savefunction", "EventController@saveFunction")->name('save-edited-function');
Route::post("/deletefunction", "EventController@deleteFunction")->name('delete-function');
Route::post("/showeditedfunction", "EventController@showEditedFunction")->name('edit-function');
