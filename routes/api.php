<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/posts',[PostController::class,'index']);
Route::get('/posts/show/{id}',[PostController::class,'show']);
Route::post('/posts/store',[PostController::class,'store']);
Route::delete('/posts/{id}',[PostController::class,'update']);
Route::put('/posts/{id}',[PostController::class,'destroy']);

Route::get('/users',[UserController::class,'index']);
Route::get('/users/show/{id}',[UserController::class,'show']);
Route::post('/users/store',[UserController::class,'store']);
Route::delete('/users/update/{id}',[UserController::class,'update']);
Route::put('/users/destroy/{id}',[UserController::class,'destroy']);