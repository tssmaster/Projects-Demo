<?php

use App\Http\Controllers\ProjectsFrontController;
use App\Http\Controllers\TasksFrontController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/projects', [ProjectsFrontController::class, 'index'])->name('projects');
Route::get('/projects/create', [ProjectsFrontController::class, 'create'])->name('projects.create');
Route::post('/projects/store', [ProjectsFrontController::class, 'store'])->name('projects.store');
Route::get('/projects/{id}', [ProjectsFrontController::class, 'view'])->name('projects.view');
Route::get('/projects/{id}/edit', [ProjectsFrontController::class, 'edit'])->name('projects.edit');
Route::patch('/projects/{id}', [ProjectsFrontController::class, 'update'])->name('projects.update');
Route::get('/projects/{id}/delete', [ProjectsFrontController::class, 'delete'])->name('projects.delete');


Route::get('/tasks/create', [TasksFrontController::class, 'create'])->name('tasks.create');
Route::post('/tasks/store', [TasksFrontController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{id}', [TasksFrontController::class, 'view'])->name('tasks.view');
Route::get('/tasks/{id}/edit', [TasksFrontController::class, 'edit'])->name('tasks.edit');
Route::patch('/tasks/{id}', [TasksFrontController::class, 'update'])->name('tasks.update');
Route::get('/tasks/{id}/delete', [TasksFrontController::class, 'delete'])->name('tasks.delete');
