<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InterviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/category' , [CategoryController::class , 'index']);
Route::post('/category' , [CategoryController::class , 'store']);
Route::put('/category/{category}' , [CategoryController::class , 'update']);
Route::delete('/category/{category}' , [CategoryController::class , 'destroy']);

Route::get('/interview' , [InterviewController::class , 'index']);
Route::post('/interview' , [InterviewController::class , 'store']);
Route::put('/interview/{interview}' , [InterviewController::class , 'update']);
Route::delete('/interview/{interview}' , [InterviewController::class , 'destroy']);

