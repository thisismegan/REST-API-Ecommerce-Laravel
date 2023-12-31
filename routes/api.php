<?php

use App\Http\Controllers\api\AddressController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\RajaongkirController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\RoleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;


// Public Routes

Route::get('/', function () {
    return  response()->json([
        'title'   => 'Sample Ecommerce API',
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
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'updatePassword'])->middleware('guest')->name('password.update');
    Route::apiResource('product', ProductController::class)->only(['index', 'show']);
    Route::apiResource('category', CategoryController::class)->only(['index', 'show']);
});


// Protected Routes User
Route::group(['middleware' => ['allow-cors', 'verified', 'auth:sanctum']], function () {
    Route::apiResource('user', UserController::class);
    Route::apiResource('cart', CartController::class)->except(['create', 'show']);
    Route::apiResource('order', OrderController::class);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('address', AddressController::class);
    Route::get('province', [RajaongkirController::class, 'getProvince']);
    Route::get('city/{id}', [RajaongkirController::class, 'getCity']);
    Route::get('postalcode/{id}', [RajaongkirController::class, 'getPostalCode']);
    Route::post('changepassword', [AuthController::class, 'changePassword']);
    Route::get('cart/count', [CartController::class, 'count']);
});

// Protected Routes Only Admin
Route::group(['middleware' => ['allow-cors', 'verified', 'auth:sanctum', 'isAdmin']], function () {
    Route::apiResource('product', ProductController::class)->except(['index', 'show']);
    Route::apiResource('role', RoleController::class)->only(['index', 'store']);
    Route::apiResource('category', CategoryController::class)->except(['index', 'show']);
    Route::post('delete_image', [ProductController::class, 'deleteImage']);
});
