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
use Illuminate\Support\Facades\URL;


// Public Routes

Route::get('/', function () {
    return  response()->json([
        'title'   => 'Sample Ecommerce APP API',
        'end point' => URL::current(),
        'contact' => [
            'name' => 'API Support',
            'email' => 'everythingaboutcode@gmail.com'
        ],
        'version' => "1.0.0"
    ]);
});
Route::group(['middleware' => 'allow-cors'], function () {
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
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('user', UserController::class);
    Route::apiResource('cart', CartController::class)->except(['create', 'show']);
    Route::apiResource('order', OrderController::class);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('address', AddressController::class);
});

// Protected Routes Only Admin
Route::group(['middleware' => ['auth:sanctum', 'isAdmin']], function () {
    Route::apiResource('product', ProductController::class)->except(['index', 'show']);
    Route::apiResource('role', RoleController::class)->only(['index', 'store']);
    Route::get('user', [UserController::class, 'index']);
    Route::apiResource('category', CategoryController::class)->except(['index', 'show']);
    Route::post('delete_image', [ProductController::class, 'deleteImage']);
});
