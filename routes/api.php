<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCustomerAuthController;
use App\Http\Controllers\ApiGetCustomerProfileController;
use App\Http\Controllers\ApiHealthCheckController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/', function () {
    return 'API';
});

Route::post('/customer/login', [ApiCustomerAuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/customer/logout', [ApiCustomerAuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/customer/profile', [ApiGetCustomerProfileController::class, 'show']);

Route::get('/health', [ApiHealthCheckController::class, 'show']);