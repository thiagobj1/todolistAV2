<?php

use App\Http\Controllers\TodolistController;
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
    return view('index');
});

Route::resource('todolist', TodolistController::class);

//Route::get('/todolist', TodolistController::class . '@index');
//Route::post('/todolist', TodolistController::class . '@store');
//Route::put('/todolist/{id}', TodolistController::class . '@update');
//Route::delete('/todolist/{id}', TodolistController::class . '@destroy');



