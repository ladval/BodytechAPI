<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UploadProducts;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|---------------------------------
-----------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Public Routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);


Route::get('/cartlist', [CartController::class, 'index']);
Route::post('/cartlist', [CartController::class, 'store']);
Route::get('/cartlist/{id}', [CartController::class, 'show']);
Route::delete('/cartlist/{id}', [CartController::class, 'destroy']);

Route::delete('/cartlistall/{id}', [CartController::class, 'destroyAll']);

Route::post('/upload-content', [UploadProducts::class, 'uploadContent']);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
