<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HobbyApiController;
use App\Http\Controllers\Api\PeopleApiController;
use App\Http\Controllers\Api\FormInputApiController;
use App\Http\Controllers\Api\PhoneNumberApiController;
use App\Http\Controllers\AuthController;

Route::prefix('v1')->middleware('api')->group(function () {
    // Normal Route
    Route::get('/hello', function () {
        return response()->json(['message' => 'Hello World!']);
    });
    Route::apiResource('people',        PeopleApiController::class);
    Route::apiResource('phone-number',  PhoneNumberApiController::class);
    Route::apiResource('hobbies',       HobbyApiController::class);

    // Login Route
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // For Authenticated Users
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});


// Route::apiResource('form', FormInputApiController::class);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
