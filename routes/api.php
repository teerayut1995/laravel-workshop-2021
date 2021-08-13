<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('users', function() {
	return 'hello api';
});

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category_id}', [CategoryController::class, 'show']);
Route::post('categories', [CategoryController::class, 'store']);
Route::patch('categories/{category_id}', [CategoryController::class, 'update']);
Route::delete('categories/{category_id}', [CategoryController::class, 'delete']);

Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{post_id}', [PostController::class, 'show']);
Route::post('posts', [PostController::class, 'store']);
Route::post('posts/{post_id}', [PostController::class, 'update']);
Route::delete('posts/{post_id}', [PostController::class, 'delete']);