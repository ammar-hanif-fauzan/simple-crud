<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormInputController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PhoneNumberController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('form', FormInputController::class);
Route::resource('people', PeopleController::class); // One To One 
Route::resource('phone-number', PhoneNumberController::class); // One To Many