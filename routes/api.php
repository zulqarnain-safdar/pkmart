<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ReferralController;
use App\Http\Controllers\Api\Admin\ReferralController as AdminReferralController;

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

// Public routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/featured', [ProductController::class, 'featured']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

// Protected routes
Route::middleware('auth:api')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::post('/orders/{order}/process-commissions', [OrderController::class, 'processCommissions']);
    
    // Payment routes
    Route::post('/payments/easypaisa/initiate', [PaymentController::class, 'initiateEasyPaisaPayment']);
    Route::get('/payments/status/{orderId}', [PaymentController::class, 'getPaymentStatus']);
    
    // Referral routes
    Route::prefix('referrals')->group(function () {
        Route::get('/my-code', [ReferralController::class, 'getMyReferralCode']);
        Route::post('/validate', [ReferralController::class, 'validateReferralCode']);
        Route::get('/earnings', [ReferralController::class, 'getEarningsHistory']);
        Route::get('/stats', [ReferralController::class, 'getReferralStats']);
        Route::post('/renew', [ReferralController::class, 'renewReferralCode']);
        Route::get('/tree', [ReferralController::class, 'getReferralTree']);
    });
});

// Admin routes
Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::get('/admin/products', [ProductController::class, 'adminIndex']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    
    Route::get('/admin/categories', [CategoryController::class, 'adminIndex']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    
    Route::get('/admin/orders', [OrderController::class, 'adminIndex']);
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
    
    // Admin referral routes
    Route::prefix('admin/referrals')->group(function () {
        Route::get('/codes', [AdminReferralController::class, 'getReferralCodes']);
        Route::get('/relationships', [AdminReferralController::class, 'getReferralRelationships']);
        Route::get('/earnings', [AdminReferralController::class, 'getReferralEarnings']);
        Route::get('/stats', [AdminReferralController::class, 'getReferralStats']);
        Route::post('/process-renewals', [AdminReferralController::class, 'processMonthlyRenewals']);
        Route::post('/codes/{referralCode}/deactivate', [AdminReferralController::class, 'deactivateReferralCode']);
        Route::post('/codes/{referralCode}/reactivate', [AdminReferralController::class, 'reactivateReferralCode']);
        Route::post('/earnings/{earning}/mark-paid', [AdminReferralController::class, 'markEarningAsPaid']);
        Route::post('/earnings/{earning}/mark-cancelled', [AdminReferralController::class, 'markEarningAsCancelled']);
    });
    
    // Admin commission routes
    Route::prefix('admin/commissions')->group(function () {
        Route::post('/products/{product}/set', [AdminReferralController::class, 'setProductCommission']);
        Route::get('/products/{product}', [AdminReferralController::class, 'getProductCommission']);
    });
});

// Public payment callback routes (no auth required)
Route::post('/payments/easypaisa/return', [PaymentController::class, 'handleEasyPaisaReturn']);
Route::post('/payments/easypaisa/notify', [PaymentController::class, 'handleEasyPaisaNotify']);

// Debug route (sandbox only, no auth required)
Route::get('/payments/easypaisa/debug', [PaymentController::class, 'debugEasyPaisaConfig']);
