<?php

use App\Http\Controllers\SecurityController;
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

    Route::get('/task', 'index')->name('task.index')->middleware('auth');
    Route::get('/task/create', 'create')->name('task.create')->middleware('auth');
    Route::get('/task/create/random', 'createRandom')->name('task.create_random')->middleware('auth');
    Route::get('/task/{id}/edit', 'edit')->where(['id' => '\d+'])->name('task.edit')->middleware('auth');
    Route::get('/task/{id}/next', 'next')->where(['id' => '\d+'])->name('task.next')->middleware('auth');
    Route::get('/task/{id}/previous', 'previous')->where(['id' => '\d+'])->name('task.previous')->middleware('auth');
    Route::get('/task/{id}/delete', 'delete')->where(['id' => '\d+'])->name('task.delete')->middleware('auth');
    Route::get('/task/{id}',  'show')->where(['id' => '\d+'])->name('task.show')->middleware('auth');


    // TODO: API separation
    Route::post('/task', 'store')->name('task.store')->middleware('auth');
    Route::put('/task/{id}', 'update')->where(['id' => '\d+'])->name('task.update')->middleware('auth');
});

Route::controller(SecurityController::class)->group(function () {


    Route::get('/register', 'register')->name('security.register');
    Route::get('/login', 'login')->name('security.login');
    Route::get('/logout', 'logout')->name('security.logout')->middleware('auth');


    // TODO: API separation
    Route::post('/register', 'store')->name('security.store');
    Route::post('/login', 'authenticate')->name('security.authenticate');
});
