<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MoviePictureController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('/users/{id}/forceDestroy', [UserController::class, 'forceDestroy'])->name('users.forceDestroy');
Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
Route::apiResource('/users', UserController::class);

Route::post('/tags/{id}/forceDestroy', [TagController::class, 'forceDestroy'])->name('tags.forceDestroy');
Route::post('/tags/{id}/restore', [TagController::class, 'restore'])->name('tags.restore');
Route::apiResource('/tags', TagController::class);

Route::post('/categories/{id}/forceDestroy', [CategoryController::class, 'forceDestroy'])->name('categories.forceDestroy');
Route::post('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
Route::apiResource('/categories', CategoryController::class);

Route::post('/movies/{id}/forceDestroy', [MovieController::class, 'forceDestroy'])->name('movies.forceDestroy');
Route::post('/movies/{id}/restore', [MovieController::class, 'restore'])->name('movies.restore');
Route::apiResource('/movies', MovieController::class);

Route::get('/movie_pictures/fetch', [MoviePictureController::class, 'fetch'])->name('movie_pictures.fetch');
