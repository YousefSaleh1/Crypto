<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\ReplyController;
use App\Http\Controllers\API\CommentController;


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

Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blog/{blog}', [BlogController::class, 'show']);
    Route::post('/create_blog', [BlogController::class, 'store']);
    Route::post('/update_blog/{blog}', [BlogController::class, 'update']);
    Route::delete('/delete_blog', [BlogController::class, 'destroy']);

    Route::get('/blog/{blog}/comments', [CommentController::class, 'index']);
    Route::get('/comment/{comment}', [CommentController::class, 'show']);
    Route::post('/blog/{blog}/create_comment', [CommentController::class, 'store']);
    Route::put('/update_comment/{comment}', [CommentController::class, 'update']);
    Route::delete('/delete_comment/{comment}', [CommentController::class, 'destroy']);

    Route::get('/comments/{comment}/replies', [ReplyController::class, 'index']);
    // Route::get('/reply/{reply}', [CommentController::class, 'show']);
    Route::post('/comment/{comment}/create_reply', [ReplyController::class, 'store']);
    Route::put('/update_reply/{reply}', [ReplyController::class, 'update']);
    Route::delete('/delete_reply/{reply}', [ReplyController::class, 'destroy']);

    Route::get('/tags', [TagController::class, 'index']);
    Route::get('/tag/{tag}', [TagController::class, 'show']);
    Route::post('/create_tag', [TagController::class, 'store']);

});
