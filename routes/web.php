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
    return view('welcome');
});

Route::any('Index/index', [\App\Http\Controllers\IndexController::class,'index']);

Route::any('Admin/index', [\App\Http\Controllers\AdminController::class,'index']);

Route::get('User/index', [\App\Http\Controllers\UserController::class,'index']);
Route::post('User/index', [\App\Http\Controllers\UserController::class,'indexAjax']);
