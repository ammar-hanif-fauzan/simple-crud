<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FormInputApiController;

Route::prefix('v1')->group(function () {
    Route::get('/hello', function () {
        return response()->json(['message' => 'Hello World!']);
    });
    Route::resource('/form', FormInputApiController::class);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

