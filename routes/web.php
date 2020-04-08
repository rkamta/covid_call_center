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
Auth::routes(['verify' => true]);
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/', 'HomeController@welcome')->name('welcome');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::group(['middleware' => 'superadmin'], function () {
    Route::group(['prefix' => 'forms'], function () {
        Route::get('/', 'FormController@index')->name('formsets');
        Route::get('/view/{slug}', 'FormController@show')->name('formset-view');
        Route::get('/add', 'FormController@add')->name('formset-add');
        // Route::get('/edit/{slug}', 'FormController@edit')->name('formset-edit');
        // Route::post('/update/{slug}', 'FormController@update')->name('formset-update');
        // Route::post('/delete/{slug}', 'FormController@delete')->name('formset-delete');
    });
});