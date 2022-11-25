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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // Employee
    Route::get('/v1/employee', 'App\Http\Controllers\EmployeeController@list')->name('api.v1.get.employee.list');
    Route::get('/v1/employee/{id}', 'App\Http\Controllers\EmployeeController@get')->name('api.v1.get.employee');
    Route::post('/v1/employee', 'App\Http\Controllers\EmployeeController@create')->name('api.v1.create.employee');
    Route::patch('/v1/employee/{id}', 'App\Http\Controllers\EmployeeController@update')->name('api.v1.update.employee');
    Route::delete('/v1/employee/{id}', 'App\Http\Controllers\EmployeeController@delete')->name('api.v1.delete.employee');


    // Workshop
    Route::get('/v1/workshop', 'App\Http\Controllers\WorkshopController@list')->name('api.v1.get.workshop.list');
    Route::get('/v1/workshop/{id}', 'App\Http\Controllers\WorkshopController@get')->name('api.v1.get.workshop');
    Route::post('/v1/workshop', 'App\Http\Controllers\WorkshopController@create')->name('api.v1.create.workshop');
    Route::patch('/v1/workshop/{id}', 'App\Http\Controllers\WorkshopController@update')->name('api.v1.update.workshop');
    Route::delete('/v1/workshop/{id}', 'App\Http\Controllers\WorkshopController@delete')->name('api.v1.delete.workshop');
//});


Route::fallback(function (){
    abort(404, 'API resource not found');
});
