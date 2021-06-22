<?php

use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\BrandController;
use App\Http\Controllers\API\v1\CartController;
use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\DiscountCodeController;
use App\Http\Controllers\API\v1\FavouriteController;
use App\Http\Controllers\API\v1\OrderController;
use App\Http\Controllers\API\v1\RecommendationController;
use App\Http\Controllers\API\v1\ReviewController;
use App\Http\Controllers\API\v1\SupplierController;
use \App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\AddressController;
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

Route::group(['prefix' => 'v1', 'middleware' => ['api', 'cors']], function () {
    route::post('login', [AuthController::class, 'login']);
    route::post('register', [AuthController::class, 'register']);

    route::resource('products', ProductController::class)
        ->only(['index', 'show']);

    route::resource('reviews', ReviewController::class)
        ->only(['index', 'store', 'update']);

    route::resource('suppliers', SupplierController::class)
        ->only(['show']);

    route::resource('categories', CategoryController::class)
        ->only(['show', 'index']);

    route::resource('brands', BrandController::class)
        ->only(['show']);
});

Route::group(['prefix' => 'v1', 'middleware' => ['jwt.verify', 'api', 'cors']], function () {
    route::post('refresh', [AuthController::class, 'refresh']);

    route::post('logout', [AuthController::class, 'logout']);

    route::get('me', [AuthController::class, 'show']);

    route::put('me', [AuthController::class, 'update']);

    route::delete('me/favourites', [FavouriteController::class, 'destroy']);

    route::put('me/carts', [CartController::class, 'update']);

    route::delete('me/carts', [CartController::class, 'destroy']);

    route::get('me/carts/count', [CartController::class, 'getCountItems']);

    route::get('me/getListWaitingReview', [ReviewController::class, 'getListWaitingReview']);

    route::get('me/addresses/active', [AddressController::class, 'showActive']);

    route::get('me/cart/discounts', [DiscountCodeController::class, 'getDiscountCodeInCart']);

    route::get('recommendations', [RecommendationController::class, 'index']);

    route::resource('addresses', AddressController::class)
        ->only(['index', 'destroy', 'store', 'update', 'show']);
    route::resource('me/favourites', FavouriteController::class)
        ->only(['index', 'store', 'destroy']);
    route::resource('me/orders', OrderController::class)
        ->only(['index', 'show', 'store']);
    route::resource('me/carts', CartController::class)
        ->only(['index', 'store']);
    route::resource('discounts', AddressController::class)
        ->only(['index']);
});
