<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RegistrationForm;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () { 
 
Route::post('registrationform', RegistrationForm::class);
    });
}
