<?php

use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\UserController;
use \App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\AddressController;
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

Route::group(['prefix' => 'v1', 'middleware' => ['api']], function () {
    route::post('login', [AuthController::class, 'login']);
    route::post('logout', [AuthController::class, 'logout']);
    route::post('register', [AuthController::class, 'register']);
    route::post('refresh', [AuthController::class, 'refresh']);
    route::get('me', [AuthController::class, 'show']);
    route::put('me', [AuthController::class, 'update']);
});

Route::group(['prefix' => 'v1', 'middleware' => ['jwt.verify', 'api']], function () {
    route::resource('addresses', AddressController::class);
    route::resource('products', ProductController::class);
});
