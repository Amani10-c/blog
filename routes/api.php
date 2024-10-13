<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LikeConroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogViewController;

use App\Models\User;

// Route::get('user/{show}',[BlogController::class,'Showprofile']);

 
// Route::get('/users', function () {
//     return UserResource::collection(User::all());
// });


//user
Route::post('users',[UserController::class,'creatUser']);

Route::post('login', [UserController::class, 'login'])->name('login');

Route::get('user/show',[UserController::class,'ShowProfile'])->middleware('auth:sanctum');

Route::put('user/edit/{user}',[UserController::class,'editProfile'])->middleware('auth:sanctum');

Route::get('users/show',[UserController::class,'viewProfile']);

//.


//blog
Route::post('blogs', [BlogController::class, 'createBlog'])->middleware('auth:sanctum');

Route::put('blogs/edit/{blog}',[BlogController::class,'editBlog'])->middleware('auth:sanctum');

Route::delete('blogs/delete/{blog}',[BlogController::class,'destroyBlog'])->middleware('auth:sanctum');
//.


//bloglike
Route::get('blogs/like/rank',[LikeConroller::class,'showRankLike'])->middleware('auth:sanctum');

Route::post('blogs/like/{id}', [LikeConroller::class, 'likeBlog'])->middleware('auth:sanctum');

Route::get('blogs/like/{id}', [LikeConroller::class, 'showLike'])->middleware('auth:sanctum');
//.

//blogview
Route::get('blogs/view/rank',[BlogViewController::class,'showRankRaeds'])->middleware('auth:sanctum');

Route::post('blogs/view/{id}', [BlogViewController::class, 'blogViews'])->middleware('auth:sanctum');

Route::get('blogs/view/{id}',[BlogViewController::class,'showBlogViews'])->middleware('auth:sanctum');
//.








