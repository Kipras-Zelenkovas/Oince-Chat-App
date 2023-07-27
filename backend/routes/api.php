<?php

use App\Http\Controllers\Authentication\SiteAuthentication;
use App\Http\Controllers\Friends\Friends;
use App\Http\Controllers\User\Updates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('register', [SiteAuthentication::class, 'register'])->middleware('guest')->name('register');
    Route::post('login', [SiteAuthentication::class, 'login'])->middleware('guest')->name('login');
    Route::post('logout', [SiteAuthentication::class, 'logout'])->middleware('auth:sanctum')->name('logout');
});

Route::prefix('user')->group(function () {
    Route::put('update', [Updates::class, 'update'])->middleware('auth:sanctum')->name('update');
    Route::get('friend_list', [Friends::class, 'friend_list'])->middleware('auth:sanctum')->name('friend.list');
    Route::get('friend_requests', [Friends::class, 'friend_requests'])->middleware('auth:sanctum')->name('friend.requests');
    Route::get('blocked_list', [Friends::class, 'blocked_list'])->middleware('auth:sanctum')->name('blocked.list');


    Route::post('friend_request', [Friends::class, 'send_request'])->middleware('auth:sanctum')->name('send.request');
    Route::put('friend_accept', [Friends::class, 'accept_request'])->middleware('auth:sanctum')->name('accept.request');
    Route::put('friend_block', [Friends::class, 'block'])->middleware('auth:sanctum')->name('friend.block');
});


Route::get('test', [Friends::class, 'test'])->middleware('auth:sanctum')->name('test');
