<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FormInputApiController;
use App\Http\Controllers\Api\PeopleApiController;
use App\Http\Controllers\Api\PhoneNumberApiController;
use App\Http\Controllers\Api\HobbyApiController;

Route::prefix('v1')->middleware('api')->group(function () {
    Route::get('/hello', function () {
        return response()->json(['message' => 'Hello World!']);
    });
    Route::apiResource('people', PeopleApiController::class); // One To One
    Route::apiResource('phone-number', PhoneNumberApiController::class); // One To Many
    Route::apiResource('hobbies', HobbyApiController::class); // Master Hobby for Many To Many
});
Route::apiResource('form', FormInputApiController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

