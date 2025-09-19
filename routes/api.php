<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Controller\HobbyApiController;
use App\Http\Controllers\Api\Controller\PeopleApiController;
use App\Http\Controllers\Api\Controller\FormInputApiController;
use App\Http\Controllers\Api\Controller\PhoneNumberApiController;
use App\Http\Controllers\Api\Controller\ApiDocumentationController;
use App\Http\Controllers\Api\Controller\SwaggerDocumentationController;
use App\Http\Controllers\AuthController;

Route::prefix('v1')->middleware('api')->group(function () {
    // Normal Route
    /**
     * Hello World endpoint
     * 
     * Test endpoint untuk mengecek API berjalan
     * @tags Test
     */
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

    // Documentation Management
    Route::get('/docs/config', [ApiDocumentationController::class, 'getConfig']);
    Route::get('/docs/filter', [ApiDocumentationController::class, 'getFilteredEndpoints']);
    Route::post('/docs/selection', [ApiDocumentationController::class, 'saveSelection']);
    Route::get('/docs/selection', [ApiDocumentationController::class, 'getSelection']);
    
    // Swagger Documentation Management
    Route::get('/swagger/config', [SwaggerDocumentationController::class, 'getConfig']);
    Route::get('/swagger/filter', [SwaggerDocumentationController::class, 'getFilteredEndpoints']);
    Route::post('/swagger/selection', [SwaggerDocumentationController::class, 'saveSelection']);
    Route::get('/swagger/selection', [SwaggerDocumentationController::class, 'getSelection']);
    Route::get('/swagger/status', [SwaggerDocumentationController::class, 'getStatus']);
});


// Route::apiResource('form', FormInputApiController::class);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
