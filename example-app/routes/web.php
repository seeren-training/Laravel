<?php

use App\Http\Controllers\TaskController;
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
    return redirect('task');
});

Route::controller(TaskController::class)->group(function () {
    Route::get('/task', 'index')->name('task.index');
    Route::match(['get', 'post'], '/task/create', 'create')->name('task.create');
    Route::match(['get', 'post'], '/task/{id}/edit', 'edit')->where(['id' => '\d+'])->name('task.edit');
    Route::get('/task/{id}/delete', 'delete')->where(['id' => '\d+'])->name('task.delete');
    Route::get('/task/{id}',  'show')->where(['id' => '\d+'])->name('task.show');
});
