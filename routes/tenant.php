<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;


/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'api',
    InitializeTenancyBySubdomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });

    // Public Routes (without authentication)
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected Routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);

        // Routes of categories:
        Route::get('/all-categories', [CategoryController::class, 'index']);
        Route::post('/create-category', [CategoryController::class, 'store']);
        Route::get('/show-category/{category}', [CategoryController::class, 'show']);
        Route::put('/update-category/{category}', [CategoryController::class, 'update']);
        Route::delete('/delete-category/{category}', [CategoryController::class, 'destroy']);

        // Routes of products:
        Route::apiResource('products', ProductController::class);

        // Routes of orders (moved inside the protected group):
        Route::apiResource('orders', OrderController::class);
    });
});
