<?php
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/posts',[PostController::class,'index']);
Route::get('/posts/{id}',[PostController::class,'show']);
Route::post('/posts',[PostController::class,'store']);
Route::delete('/posts/{id}',[PostController::class,'update']);
Route::put('/posts/{id}',[PostController::class,'destroy']);

Route::get('/users',[UserController::class,'index']);
Route::get('/users/{id}',[UserController::class,'show']);
Route::post('/users',[UserController::class,'store']);
Route::delete('/users/{id}',[UserController::class,'update']);
Route::put('/users/{id}',[UserController::class,'destroy']);