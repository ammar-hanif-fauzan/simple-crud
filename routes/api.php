<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FormInputApiController;
use App\Http\Controllers\Api\PeopleApiController;

Route::prefix('v1')->middleware('api')->group(function () {
    Route::get('/hello', function () {
        return response()->json(['message' => 'Hello World!']);
    });
    Route::apiResource('people', PeopleApiController::class);
    Route::apiResource('form', FormInputApiController::class);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

