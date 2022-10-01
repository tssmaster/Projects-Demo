<?php

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('projects', 'ProjectsController@index')->name('projects');
    Route::get('projects/{id}', 'ProjectsController@view')->name('projects.view');
    Route::post('projects', 'ProjectsController@store')->name('projects.store');
    Route::put('projects/{id}', 'ProjectsController@update')->name('projects.update');
    Route::delete('projects/{id}', 'ProjectsController@delete')->name('projects.delete');

    Route::get('tasks', 'TasksController@index')->name('tasks');
    Route::get('tasks/{id}', 'TasksController@view')->name('tasks.view');
    Route::post('tasks', 'TasksController@store')->name('tasks.store');
    Route::put('tasks/{id}', 'TasksController@update')->name('tasks.update');
    Route::delete('tasks/{id}', 'TasksController@delete')->name('tasks.delete');

});