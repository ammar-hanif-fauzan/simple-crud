<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormInputController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PhoneNumberController;
use App\Http\Controllers\HobbyController;
use App\Http\Controllers\PeopleHobbyController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('form', FormInputController::class);
Route::resource('people', PeopleController::class); // One To One with IdCard && Many To Many with Hobby
Route::resource('phone-number', PhoneNumberController::class); // One To Many
Route::resource('hobbies', HobbyController::class); // Master Hobby for Many To Many