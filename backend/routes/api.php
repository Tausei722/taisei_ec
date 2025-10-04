<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Review routes (authenticated)
    Route::apiResource('reviews', ReviewController::class);
    Route::post('/reviews/{review}/helpful', [ReviewController::class, 'toggleHelpful']);

    // Cart routes (keeping for backward compatibility)
    Route::apiResource('cart', CartItemController::class);
    Route::delete('/cart', [CartItemController::class, 'clear']);

    // Order routes (keeping for backward compatibility)
    Route::apiResource('orders', OrderController::class)->only(['index', 'show', 'store']);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus']);
});

// Public routes
Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);

// Review site routes (public)
Route::apiResource('businesses', BusinessController::class);
Route::get('/reviews', [ReviewController::class, 'index']);
Route::get('/reviews/{review}', [ReviewController::class, 'show']);

// Admin routes (for now, same as authenticated routes - add admin middleware later)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('admin/categories', CategoryController::class);
    Route::apiResource('admin/products', ProductController::class);
    Route::apiResource('admin/businesses', BusinessController::class);
    Route::apiResource('admin/orders', OrderController::class)->only(['index', 'show', 'update']);
});