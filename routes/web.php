<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\IndexController;
use \App\Http\Controllers\AdminController;
use \App\Http\Controllers\LoginController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\PusherController;
use \App\Http\Controllers\TestRedisController;
use \App\Http\Controllers\TestQueueController;
use \App\Http\Controllers\RedisSubscribeController;

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

Route::any('Index/index', [IndexController::class,'index']);

Route::any('Admin/index', [AdminController::class,'index']);
Route::any('Login/index', [LoginController::class,'index']);
Route::any('Login/login', [LoginController::class,'login']);
Route::any('Login/logout', [LoginController::class,'logout']);

Route::get('User/index', [UserController::class,'index']);
Route::post('User/index', [UserController::class,'indexAjax']);
Route::any('User/admin', [AdminController::class,'index']);
Route::any('User/info', [UserController::class,'info']);
Route::any('User/editUser', [UserController::class,'editUser']);
Route::any('User/editInfo', [UserController::class,'editInfo']);
Route::any('User/delUser', [UserController::class,'delUser']);
Route::any('User/addUser', [UserController::class,'addUser']);
Route::any('User/check', [UserController::class,'check']);

Route::any('Pusher/index', [PusherController::class,'index']);
Route::any('Pusher/send', [PusherController::class,'send']);

Route::any('TestRedis/index', [TestRedisController::class,'index']);
Route::any('RedisSubscribe/index', [RedisSubscribeController::class,'index']);
Route::any('TestQueue/index', [TestQueueController::class,'index']);
Route::any('TestQueue/send', [TestQueueController::class,'send']);


Route::any('guangbo/index', function (){
    broadcast(new \App\Events\MessageEvent(date('Y-m-d H:i:s').' 一条消息'));
});