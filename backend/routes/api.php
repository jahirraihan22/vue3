<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// public route
Route::get('/products',[ProductController::class,'index']);
Route::get('/product/{id}',[ProductController::class,'show']);
Route::get('/product/search/{name}',[ProductController::class,'search']);

// user route
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);


// protected route
Route::group(['middleware' => 'auth:sanctum'], function (){
    Route::post('/products',[ProductController::class,'store']);
    Route::put('/product/{id}',[ProductController::class,'update']);
    Route::delete('/product/{id}',[ProductController::class,'destroy']);

    Route::post('/logout',[AuthController::class,'logout']);

});

// Route::resource('products',ProductController::class);
