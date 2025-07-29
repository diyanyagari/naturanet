<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCustomerAuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/', function () {
    return 'API';
});

Route::post('/customer/login', [ApiCustomerAuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/customer/logout', [ApiCustomerAuthController::class, 'logout']);