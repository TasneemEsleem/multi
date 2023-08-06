<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DataEntryController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderCustomersController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RoleController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('/Forget-Password', [AuthController::class, 'ForgetPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // Landing-Page Show Restaurant-Category-Item
    Route::get('restaurant/all', [RestaurantController::class, 'ViewRestaurant']);
    Route::get('restaurant/category/{restaurant}', [RestaurantController::class, 'showCategory']);
    Route::get('category/viewItem/{category}', [RestaurantController::class, 'showItem']);
    Route::get('landingPage/items/{item}', [OrderItemController::class, 'show']);

    // Add to Cart
    Route::post('/cart/store', [CartController::class, 'addToCart']);
    // Order Item
    Route::post('/store/order', [CheckoutController::class, 'placeOrder']);
    // Payment Strip
    Route::post('/create-payment-intent/{order}', [PaymentsController::class, 'createAndConfirmStripePaymentIntent']);
    // All Cart To Customer
    Route::get('/cart',[CartController::class, 'getCarts' ] );
    // All Order to Customer
    Route::get('/order',[CartController::class, 'getOrder' ] );

    Route::post('/Change-Password', [AuthController::class, 'changePassword']);
    Route::post('/updateProfile', [ProfileController::class, 'editProfile']);
    
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::put('/roles/{role}', [RoleController::class, 'update']);
    Route::delete('/roles/{role}', [RoleController::class, 'destroy']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
    Route::get('/restaurants', [RestaurantController::class, 'index']);
    Route::post('/restaurants', [RestaurantController::class, 'store']);
    Route::put('/restaurants/{restaurant}', [RestaurantController::class, 'update']);
    Route::delete('/restaurants/{restaurant}', [RestaurantController::class, 'destroy']);
    Route::post('/restaurants/{id}/restore', [RestaurantController::class, 'restore']);
    Route::delete('/restaurants/{id}/forceDelete', [RestaurantController::class, 'forceDelete']);
    Route::get('/permissions', [PermissionController::class, 'index']);
    Route::get('/OrderCutomer', [OrderCustomersController::class, 'index']);
    Route::post('/chat/send-message', [MessageController::class, 'sendMessage']);
    Route::post('/chat/admin/send-message', [MessageController::class, 'sendMessageCustomer']);
    Route::get('/items', [ItemController::class, 'index']);
    Route::post('/items', [ItemController::class, 'store']);
    Route::put('/items/{item}', [ItemController::class, 'update']);
    Route::delete('/items/{item}', [ItemController::class, 'destroy']);
    Route::get('/dataentries', [DataEntryController::class, 'index']);
    Route::post('/dataentries', [DataEntryController::class, 'store']);
    Route::put('/dataentries/{dataentry}', [DataEntryController::class, 'update']);
    Route::delete('/dataentries/{dataentry}', [DataEntryController::class, 'destroy']);
    Route::get('/financials', [FinancialController::class, 'index']);
    Route::post('/financials', [FinancialController::class, 'store']);
    Route::put('/financials/{financial}', [FinancialController::class, 'update']);
    Route::delete('/financials/{financial}', [FinancialController::class, 'destroy']);

});
