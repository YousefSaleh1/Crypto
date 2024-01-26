<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ChangePasswordController;
use App\Http\Controllers\API\ResetpasswordController;
use App\Http\Controllers\API\SocialiteController;
use App\Http\Controllers\API\UserinfoController;
use App\Http\Controllers\API\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('login/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);

Route::post('forgetpassword', [ResetpasswordController::class, 'sendemail']);
Route::post('reset-password', [ResetpasswordController::class, 'reset']);






Route::group(['middleware' => ['auth:sanctum']], function (){

    Route::post('change_password',[ChangePasswordController::class,'updatePassword']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resource('userinfo',UserinfoController::class);

    Route::get('verification', [VerificationController::class, 'index']);
    Route::get('verification/{id}', [VerificationController::class, 'show']);
    Route::post('verification', [VerificationController::class, 'store']);
    Route::post('verification/{id}', [VerificationController::class, 'update']);
    Route::delete('verification/{id}', [VerificationController::class, 'destroy']);

});






