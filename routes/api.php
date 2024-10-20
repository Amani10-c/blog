<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LikeConroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogViewController;

use App\Models\User;


Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('/users')->controller(UserController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/', 'Show');
        Route::post('/', 'store');
        Route::post('/', 'login');
        Route::put('/{user}', 'update');
        Route::delete('/{user}', 'destroy');
    });

    Route::prefix('/blogs')->controller(BlogController::class)->group(function () {
        Route::post('/', 'store');
        Route::get('/', 'index');
        Route::get('/', 'show');
        Route::put('/{blog}', 'update');
        Route::delete('/{blog}', 'destroy');
    });

    Route::prefix('likes')->controller(LikeConroller::class)->group(function () {
        Route::get('/', 'showRankLike');
        Route::post('/{blog}', 'store');
        Route::delete('/{id}', 'destroy');
        Route::get('/{blog}', 'show');
    });

    Route::prefix('views')->controller(BlogViewController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/{id}', 'store');
        Route::get('/{blog}', 'show');
    });
});
