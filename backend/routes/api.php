<?php

use App\Http\Controllers\Authentication\SiteAuthentication;
use App\Http\Controllers\Friends\Friends;
use App\Http\Controllers\Group\CRUD;
use App\Http\Controllers\Group\Get;
use App\Http\Controllers\Group\Join;
use App\Http\Controllers\Group\Users;
use App\Http\Controllers\User\ResetPassword;
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
    Route::prefix('password')->group(function () {
        Route::post('forgot', [ResetPassword::class, 'forgot_password'])->middleware('guest')->name('forgot.password');
        Route::post('reset', [ResetPassword::class, 'reset_password'])->middleware('guest')->name('reset.password');
    });

    Route::prefix('friends')->group(function () {
        Route::get('list', [Friends::class, 'friend_list'])->middleware('auth:sanctum')->name('friend.list');
        Route::get('requests', [Friends::class, 'friend_requests'])->middleware('auth:sanctum')->name('friend.requests');
        Route::get('blocked', [Friends::class, 'blocked_list'])->middleware('auth:sanctum')->name('blocked.list');


        Route::post('request', [Friends::class, 'send_request'])->middleware('auth:sanctum')->name('send.request');
        Route::put('accept', [Friends::class, 'accept_request'])->middleware('auth:sanctum')->name('accept.request');
        Route::put('block', [Friends::class, 'block'])->middleware('auth:sanctum')->name('friend.block');

        Route::post('cancle_request', [Friends::class, 'cancle_request'])->middleware('auth:sanctum')->name('cancle.request');
        Route::post('cancle_friendship', [Friends::class, 'cancle_friendship'])->middleware('auth:sanctum')->name('cancle.friendship');
        Route::put('unblock', [Friends::class, 'unblock'])->middleware('auth:sanctum')->name('unblock.user');
    });
});

Route::prefix('group')->group(function () {

    Route::get('', [Get::class, 'get'])->middleware('auth:sanctum')->name('get.groups');
    Route::get('find', [Get::class, 'find'])->middleware('auth:sanctum')->name('find.group');

    Route::post('', [CRUD::class, 'create'])->middleware('auth:sanctum')->name('create.group');
    Route::put('', [CRUD::class, 'update'])->middleware('auth:sanctum')->name('update.group');
    Route::delete('', [CRUD::class, 'delete'])->middleware('auth:sanctum')->name('delete.group');

    Route::get('requesters', [Users::class, 'requesters'])->middleware('auth:sanctum')->name('requesters.group');
    Route::prefix('members')->group(function () {
        Route::get('', [Users::class, 'members'])->middleware('auth:sanctum')->name('members.group');
        Route::get('banned', [Users::class, 'banned'])->middleware('auth:sanctum')->name('banned.group');

        Route::post('join', [Join::class, 'join'])->middleware('auth:sanctum')->name('join.group');
        Route::put('accept', [Join::class, 'accept'])->middleware('auth:sanctum')->name('accept.member');
        Route::put('ban', [Users::class, 'ban'])->middleware('auth:sanctum')->name('ban.member');
    });
});
