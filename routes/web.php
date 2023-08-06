<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DataEntryController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderCustomersController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RestPasswordController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('guest')->group(function () {

    // ControlPanel
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegister']);
    // Landing Page
    Route::get('/', [DashboardController::class, 'indexCustomer'])->name('dashboard-customer');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::get('/login/Customer', [AuthController::class, 'loginCustomer'])->name('loginCustomer');

    // Forget Password
    Route::get('/ForgetPassword', [RestPasswordController::class, 'index'])->name('ForgetPassword');
    Route::post('/Forget-Password', [RestPasswordController::class, 'ForgetPassword'])->name('Forget-Password');
    Route::get('/Reset-password/{token}', [RestPasswordController::class, 'showResetPassword'])->name('password.reset');
    Route::post('reset-password', [RestPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/Edit-Password', [AuthController::class, 'editPassword'])->name('Edit-Password');
    Route::post('/Update-Password', [AuthController::class, 'updatePassword'])->name('Update-Password');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('restaurants', RestaurantController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('dataentries', DataEntryController::class);
    Route::resource('financials', FinancialController::class);
    Route::resource('items', ItemController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/roles/{role}/permissions', [RoleController::class, 'editRolePermission'])->name('roles.editPermission');
    Route::put('/roles/{role}/permission', [RoleController::class, 'updateRolePermission']);
    Route::get('/trashed', [RestaurantController::class, 'trashed'])->name('trashed');
    Route::post('/restaurants/{id}/restore', [RestaurantController::class, 'restore'])->name('restore');
    Route::delete('/restaurants/{id}/forceDelete', [RestaurantController::class, 'forceDelete'])->name('force-delete');
    Route::get('/OrderCutomer', [OrderCustomersController::class, 'index'])->name('OrderCustomer');
    Route::post('/chat/admin/send-message', [MessageController::class, 'sendMessageCustomer'])->name('send.message.customer');
    Route::get('/chat/admin/customer', [MessageController::class, 'chatAdmin'])->name('chat.admin');
    Route::get('/chat/admin/{user_id}', [MessageController::class, 'getMessages'])->name('chatt.all');


});

// Verify Email
Route::middleware(['auth:user'])->group(function () {
    Route::get('verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('send-verification', [EmailVerificationController::class, 'send'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
});

// LandingPage   , 'verified'
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'indexCustomer'])->name('dashboard-customer');
    Route::post('/UserOrder/store', [OrderItemController::class, 'store'])->name('useritem.store');
    Route::get('/orderItem/checkout', [OrderItemController::class, 'viewCheckout'])->name('OrderCheckout');
    Route::get('/chat/custmer', [MessageController::class, 'chat'])->name('chat.view');
    Route::post('/chat/send-message', [MessageController::class, 'sendMessage'])->name('send.messages');
    Route::get('/chat/{restaurant_id}', [MessageController::class, 'index'])->name('chat.all');

    // All Operitaion
    Route::get('/orderItem', [OrderItemController::class, 'index'])->name('OrderItem');
    Route::get('/cart', [CartController::class, 'index'])->name('ViewCart');
    Route::post('/cart/store', [CartController::class, 'store']);
    Route::get('/checkout/create', [CheckoutController::class, 'create'])->name('ViewCheckout');
    Route::post('/checkout/store', [CheckoutController::class, 'store']);
    Route::get('restaurant/all', [RestaurantController::class, 'ViewRestaurant'])->name('ViewRestaurant');
    Route::get('restaurant/category/{restaurant}', [RestaurantController::class, 'showCategory'])->name('restaurant.category');
    Route::get('category/viewItem/{category}', [RestaurantController::class, 'showItem'])->name('category.item');
    Route::get('landingPage/items/{item}', [OrderItemController::class, 'show'])->name('item.show');
    // Stripe Payment
    Route::get('/order/{order}/payment', [PaymentsController::class, 'create'])->name('Payment.create');
    Route::post('/order/{order}/stripe/payment', [PaymentsController::class, 'createStripePaymentIntent'])->name('stripe.paymentIntel.create');
    Route::get('/order/{order}/pay/stripe/callback', [PaymentsController::class, 'confirm'])->name('stripe.return');

});
