<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LikeConroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogViewController;

use App\Models\User;



//user
Route::post('users', [UserController::class, 'store']);

Route::post('login', [UserController::class, 'login'])->name('login');

Route::get('user/show', [UserController::class, 'Show'])->middleware('auth:sanctum');

Route::put('user/update/{user}', [UserController::class, 'update'])->middleware('auth:sanctum');

Route::get('users/index', [UserController::class, 'index']);

Route::delete('users/delete/{user}', [UserController::class, 'destroy']);

//.


//blog

Route::post('blogs', [BlogController::class, 'store'])->middleware('auth:sanctum');

Route::get('blogs/index', [BlogController::class, 'index'])->middleware('auth:sanctum');

Route::get('blogs/show', [BlogController::class, 'show'])->middleware('auth:sanctum');

Route::put('blogs/update/{blog}', [BlogController::class, 'update'])->middleware('auth:sanctum');

Route::delete('blogs/delete/{blog}', [BlogController::class, 'destroy'])->middleware('auth:sanctum');
//.


//bloglike
Route::get('blogs/like/rank', [LikeConroller::class, 'showRankLike'])->middleware('auth:sanctum');

Route::post('blogs/like/{blog}', [LikeConroller::class, 'store'])->middleware('auth:sanctum');

Route::delete('like/delete/{id}', [LikeConroller::class, 'destroy'])->middleware('auth:sanctum');

Route::get('like/show/{blog}', [LikeConroller::class, 'show'])->middleware('auth:sanctum');
//.

//blogview
Route::get('blogs/view/rank', [BlogViewController::class, 'index'])->middleware('auth:sanctum');

Route::post('blogs/view/{id}', [BlogViewController::class, 'store'])->middleware('auth:sanctum');

Route::get('blogs/view/{blog}', [BlogViewController::class, 'show'])->middleware('auth:sanctum');
//.