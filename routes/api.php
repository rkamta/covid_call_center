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

Route::get('/formdata', function (Request $request) {
    return json_encode("[]");
});

Route::post('/formdata', function (Request $request) {
    return json_encode("POST REQUEST");
});

Route::post('/form', function (Request $request) {
    return json_encode($request->post());
});