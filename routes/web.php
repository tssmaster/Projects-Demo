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
    return redirect('/projects');
})->middleware('auth');


Auth::routes();

Route::get('/projects',             'ProjectsFrontController@index')->name('projects');
Route::get('/projects/create',      'ProjectsFrontController@create')->name('projects.create');
Route::post('/projects/store',      'ProjectsFrontController@store')->name('projects.store');
Route::get('/projects/{id}',        'ProjectsFrontController@view')->name('projects.view');
Route::get('/projects/{id}/edit',   'ProjectsFrontController@edit')->name('projects.edit');
Route::patch('/projects/{id}',      'ProjectsFrontController@update')->name('projects.update');
Route::get('/projects/{id}/delete', 'ProjectsFrontController@delete')->name('projects.delete');


Route::get('/tasks/create',      'TasksFrontController@create')->name('tasks.create');
Route::post('/tasks/store',      'TasksFrontController@store')->name('tasks.store');
Route::get('/tasks/{id}',        'TasksFrontController@view')->name('tasks.view');
Route::get('/tasks/{id}/edit',   'TasksFrontController@edit')->name('tasks.edit');
Route::patch('/tasks/{id}',      'TasksFrontController@update')->name('tasks.update');
Route::get('/tasks/{id}/delete', 'TasksFrontController@delete')->name('tasks.delete');
