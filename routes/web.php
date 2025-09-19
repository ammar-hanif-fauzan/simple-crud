<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormInputController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PhoneNumberController;
use App\Http\Controllers\HobbyController;
use App\Http\Controllers\PeopleHobbyController;

use App\Http\Controllers\ManageApiController;
Route::get('/', function () {
    return view('welcome');
});

Route::resource('form', FormInputController::class);
Route::resource('people', PeopleController::class); // One To One with IdCard && Many To Many with Hobby
Route::resource('phone-number', PhoneNumberController::class); // One To Many
Route::resource('hobbies', HobbyController::class); // Master Hobby for Many To Many

Route::get('/manage/api', [ManageApiController::class, 'index'])->name('manage.api');
Route::post('/manage/api', [ManageApiController::class, 'test'])->name('manage.api.test');

Route::get('/api-docs', function () {
    return view('api-docs');
});