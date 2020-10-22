<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterationController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/init-register', [RegisterationController::class, 'init']);
Route::post('/complete-register', [RegisterationController::class, 'complete'])->middleware('auth:sanctum');
Route::post('/login', LoginController::class);
Route::post('/verify-email', VerificationController::class);
Route::post('/send-forgot-password', [ForgotPasswordController::class, 'sendOtp']);
Route::post('/change-password', [ForgotPasswordController::class, 'changePassword']);
Route::resource('/categories', CategoryController::class);
Route::resource('/posts', PostController::class);
