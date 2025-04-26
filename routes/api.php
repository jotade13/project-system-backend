<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/test', function(){return('asdasd');});


Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
 //   Route::post(/);

    Route::get('/users',[UserController::class,'index']);
    Route::put('/users/{task:id}',[UserController::class,'update']);
    Route::delete('/users/{task:id}',[UserController::class,'destroy']);
    
    Route::post('/projects',[ProjectController::class,'store']);
    Route::get('/projects',[ProjectController::class,'index']);
    Route::put('/projects/{project:id}',[ProjectController::class,'update']);
    Route::delete('/projects/{project:id}',[ProjectController::class,'destroy']);
    Route::get('/projects/{project:id}',[ProjectController::class,'show']);

    Route::post('/tasks',[TaskController::class,'store']);
    Route::get('/tasks',[TaskController::class,'index']);
    Route::put('/tasks/{task:id}',[TaskController::class,'update']);
    Route::delete('/tasks/{task:id}',[TaskController::class,'destroy']);
    Route::get('/tasks/{task:id}',[TaskController::class,'show']);
});