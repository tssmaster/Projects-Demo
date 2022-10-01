<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;
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

    Route::get('projects', [ProjectsController::class, 'index'])->name('projects');
    Route::get('projects/{id}', [ProjectsController::class, 'view'])->name('projects.view');
    Route::post('projects', [ProjectsController::class, 'store'])->name('projects.store');
    Route::put('projects/{id}', [ProjectsController::class, 'update'])->name('projects.update');
    Route::delete('projects/{id}', [ProjectsController::class, 'delete'])->name('projects.delete');

    Route::get('tasks', [TasksController::class, 'index'])->name('tasks');
    Route::get('tasks/{id}', [TasksController::class, 'view'])->name('tasks.view');
    Route::post('tasks', [TasksController::class, 'store'])->name('tasks.store');
    Route::put('tasks/{id}', [TasksController::class, 'update'])->name('tasks.update');
    Route::delete('tasks/{id}', [TasksController::class, 'delete'])->name('tasks.delete');

});
