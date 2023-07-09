<?php

use App\Http\Controllers\api\AddressController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\RoleController;
use Illuminate\Support\Facades\Route;

// Public Routes

Route::group(['middleware' => 'allow-cors'], function () {
    Route::get('/', function () {
        return response()->json([
            'status' => 200,
            'message' => "api end point"
        ]);
    });
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('activate/{token}', [AuthController::class, 'mailActivation'])->name('mail.activate');
    Route::post('forgot_password', [AuthController::class, 'forgotPassword']);
    Route::get('check_token/{email}/{token}', [AuthController::class, 'checkToken'])->name('check_token');
    Route::post('reset_password', [AuthController::class, 'resetPassword']);
    Route::apiResource('product', ProductController::class)->only(['index', 'show']);
    Route::apiResource('category', CategoryController::class)->only(['index', 'show']);
});


// Protected Routes User
Route::group(['middleware' => ['allow-cors', 'auth:sanctum']], function () {
    Route::apiResource('user', UserController::class);
    Route::apiResource('cart', CartController::class);
    Route::apiResource('order', OrderController::class);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('address', AddressController::class);
});

// Protected Routes Only Admin
Route::group(['middleware' => ['allow-cors', 'auth:sanctum', 'isAdmin']], function () {
    Route::apiResource('product', ProductController::class)->except(['index', 'show']);
    Route::apiResource('role', RoleController::class);
    Route::get('user', [UserController::class, 'index']);
    Route::apiResource('category', CategoryController::class)->except(['index', 'show']);
    Route::post('delete_image', [ProductController::class, 'deleteImage']);
});
