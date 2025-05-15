<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

// User authentication routes (public)
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

// Public product routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::get('/users/{user}/orders', [UserController::class, 'showOrders']);
    
    // Protected product routes
    Route::post('/products', [ProductController::class, 'store']);
    Route::post('/products/upload', [ProductController::class, 'uploadFile']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::patch('/products/{product}/quantity', [ProductController::class, 'updateQuantity']); 
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    
    // Order routes (all protected)
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::put('/orders/{order}', [OrderController::class, 'update']);
    Route::delete('/orders/{order}', [OrderController::class, 'destroy']);
    Route::post('/orders/{order}/deliver', [OrderController::class, 'deliverOrder']);
});