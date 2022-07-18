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
Route::post('register', [App\Http\Controllers\API\PassportAuthController::class, 'register']);

Route::post('/login',[App\Http\Controllers\API\PassportAuthController::class,'login']);

Route::post('profileupdate', [App\Http\Controllers\API\PassportAuthController::class, 'updateprofile']);

Route::get('deleteuser/{id}', 'ApiController\PassportController@destroys');

Route::get('users', [App\Http\Controllers\API\PassportAuthController::class, 'view']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
