<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::get('me', [AuthController::class, 'me'])->name('me');
    Route::post('change-password', [AuthController::class, 'change_password'])->name('change_password');
});

Route::group(['middleware' => ['api', 'auth:api', 'check.token.expiry'], 'prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, '__invoke'])->name('all');
    Route::get('/export-excel', [CategoryController::class, 'export_excel'])->name('export_excel');
    Route::get('/{id}', [CategoryController::class, 'detail'])->name('detail');
    Route::post('/', [CategoryController::class, 'insert'])->name('insert');
    Route::post('/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
});

Route::group(['middleware' => ['api', 'auth:api', 'check.token.expiry'], 'prefix' => 'brands'], function () {
    Route::get('/', [BrandController::class, '__invoke'])->name('all');
    Route::get('/export-excel', [BrandController::class, 'export_excel'])->name('export_excel');
    Route::get('/{id}', [BrandController::class, 'detail'])->name('detail');
    Route::post('/', [BrandController::class, 'insert'])->name('insert');
    Route::post('/{id}', [BrandController::class, 'update'])->name('update');
    Route::delete('/{id}', [BrandController::class, 'destroy'])->name('destroy');
});

Route::group(['middleware' => ['api', 'auth:api', 'check.token.expiry'], 'prefix' => 'products'], function () {
    Route::get('/', [ProductController::class, '__invoke'])->name('all');
    Route::get('/export-excel', [ProductController::class, 'export_excel'])->name('export_excel');
    Route::get('/{id}', [ProductController::class, 'detail'])->name('detail');
    Route::post('/', [ProductController::class, 'insert'])->name('insert');
    Route::post('/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
});
