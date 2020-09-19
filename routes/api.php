<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/mobile-login', "AdminController@apiLogin");
Route::post('/mobile-register', "AdminController@apiRegister");
Route::post('/mobile-verify', "AdminController@apiVerification");
Route::post('/mobile-guest-requests', 'AdminHomepageController@showRequests');
Route::post('/mobile-functions', 'EventController@showFunction');
Route::post('/mobile-guests', 'AdminHomepageController@showGuests');
Route::post('/mobile-cancelled-requests', 'AdminHomepageController@showCancelledRequests');
