<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadProducts;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesReportController;



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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);


//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //--------------------------------------------------------------------------
    Route::post('/cart-add', [CartController::class, 'add']);
    Route::get('/cart-checkout', [CartController::class, 'checkout']);
    Route::delete('/cart-removeitem/{id}', [CartController::class, 'removeitem']);
    Route::get('/cart-clear', [CartController::class, 'clear']);
    Route::get('/cart-shopping', [CartController::class, 'shopping']);
    //--------------------------------------------------------------------------
    Route::post('/upload-content', [UploadProducts::class, 'uploadContent']);
    //--------------------------------------------------------------------------
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    //--------------------------------------------------------------------------
    Route::post('/salesreport', [CartController::class, 'salesreport']);
    //--------------------------------------------------------------------------
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
