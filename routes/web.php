<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('verify', [AuthController::class, 'verify'])->name('verify');
    });
});

Route::middleware('auth.multiple:web-admin,web-user')->group(function () {
    Route::prefix('products')->name('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('list');
        Route::post('update', [ProductController::class, 'update']);
    });
});
