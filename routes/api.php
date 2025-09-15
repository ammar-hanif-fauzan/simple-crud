<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Controller\HobbyApiController;
use App\Http\Controllers\Api\Controller\PeopleApiController;
use App\Http\Controllers\Api\Controller\FormInputApiController;
use App\Http\Controllers\Api\Controller\PhoneNumberApiController;
use App\Http\Controllers\AuthController;

Route::prefix('v1')->middleware('api')->group(function () {
    // Normal Route
    Route::get('/hello', function () {
        return response()->json(['message' => 'Hello, Happy World!']);
    });
    // Route::apiResource('people',        PeopleApiController::class);
    // Route::apiResource('phone-number',  PhoneNumberApiController::class);
    // Route::apiResource('hobbies',       HobbyApiController::class);

    // People
    Route::get   ('people',         [PeopleApiController::class, 'index']);
    Route::post  ('people',         [PeopleApiController::class, 'store']);
    Route::get   ('people/{id}',    [PeopleApiController::class, 'show']);
    Route::put   ('people/{id}',    [PeopleApiController::class, 'update']);
    Route::delete('people/{id}',    [PeopleApiController::class, 'destroy']);

    // Phone Number
    Route::get   ('phone-number',         [PhoneNumberApiController::class, 'index']);
    Route::post  ('phone-number',         [PhoneNumberApiController::class, 'store']);
    Route::get   ('phone-number/{id}',    [PhoneNumberApiController::class, 'show']);
    Route::put   ('phone-number/{id}',    [PhoneNumberApiController::class, 'update']);
    Route::delete('phone-number/{id}',    [PhoneNumberApiController::class, 'destroy']);

    // Hobbies
    Route::get   ('hobbies',         [HobbyApiController::class, 'index']);
    Route::post  ('hobbies',         [HobbyApiController::class, 'store']);
    Route::get   ('hobbies/{id}',    [HobbyApiController::class, 'show']);
    Route::put   ('hobbies/{id}',    [HobbyApiController::class, 'update']);
    Route::delete('hobbies/{id}',    [HobbyApiController::class, 'destroy']);

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
