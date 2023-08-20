<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api', 'jwt.auth'], function () {
    Route::prefix('admin')->group(function () {
        Route::post('verify', [AuthController::class, 'verify']);
        Route::middleware('auth:admin')->group(function () {
            Route::prefix('products')->group(function () {
                Route::get('/', [ProductController::class, 'index']);
                Route::post('update', [ProductController::class, 'update']);
            });
        });
    });

    Route::prefix('user')->group(function () {
        Route::post('verify', [AuthController::class, 'verify']);
        Route::middleware('auth:user')->group(function () {
            Route::get('dashboard', [UserController::class, 'dashboard']);
        });
    });
});
