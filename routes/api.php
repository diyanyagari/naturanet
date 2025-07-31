<?php

use App\Http\Controllers\ApiBankSampahController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCustomerAuthController;
use App\Http\Controllers\ApiGetCustomerProfileController;
use App\Http\Controllers\ApiHealthCheckController;

Route::post('/customer/login', [ApiCustomerAuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/customer/logout', [ApiCustomerAuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/customer/profile', [ApiGetCustomerProfileController::class, 'show']);

Route::get('/health', [ApiHealthCheckController::class, 'show']);

Route::middleware('auth:sanctum')->get('/bank-sampah', [ApiBankSampahController::class, 'index']);
Route::middleware('auth:sanctum')->get('/bank-sampah/{id}', [ApiBankSampahController::class, 'show']);