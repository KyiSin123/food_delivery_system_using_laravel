<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminShopController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminMenuTypeController;

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

/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
 */

Route::get('/', [HomePageController::class, 'index'])
    ->name('home');

Route::get('/register', [RegisterController::class, 'create'])
    ->middleware('guest')
    ->name('register');
Route::post('/register', [RegisterController::class, 'store'])
    ->middleware('guest');

Route::get('/login', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('login');
Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest');

// Shops Routes
Route::get('/shop/register', [ShopController::class, 'create'])
    ->middleware('guest')
    ->name('shops.register');
Route::post('/shop/register', [ShopController::class, 'store'])
    ->middleware('guest');
Route::get('/shop/list', [ShopController::class, 'index'])
    ->name('shops.index');
Route::get('/shop/{id}/show', [ShopController::class, 'show'])
    ->name('shops.show');

Route::middleware('auth')->group( function() {
    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');
    Route::get('/shop/{id}/edit', [ShopController::class, 'edit'])
        ->name('shops.edit');
    Route::put('/shop/{id}/edit', [ShopController::class, 'update']);
    Route::post('/shop/{id}/favorite/add', [ShopController::class, 'favoriteAdd'])
        ->name('favorite.add');
    Route::get('/favorite/list', [ShopController::class, 'favoriteList'])
        ->name('shops.favorite');
    Route::get('/shop/{id}/checkout', [ShopController::class, 'getBuyerInfo'])
        ->name('shops.checkout');
    Route::post('/shop/{id}/checkout', [ShopController::class, 'checkout']);
    Route::post('shops/{id}/rating/store', [ShopController::class, 'reviewStore'])
        ->name('review.store');    
    Route::get('/shop/{id}/menu/create', [MenuController::class, 'create'])
        ->name('menus.create');
    Route::post('/shop/{id}/menu/create', [MenuController::class, 'store']);
    Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])
        ->name('menus.edit');
    Route::put('/menu/{id}/edit', [MenuController::class, 'update']);
    Route::delete('/menu/{id}/delete', [MenuController::class, 'destroy'])
        ->name('menus.destroy');
    Route::get('/menu/{id}/add', [MenuController::class, 'addToCart'])
        ->name('add-to-cart');
    Route::patch('/cart/update', [MenuController::class, 'updateCart'])
        ->name('update.cart');
    Route::patch('/cart/subtract', [MenuController::class, 'subtractCart'])
        ->name('cart.subtract');
    Route::delete('/cart/delete', [MenuController::class, 'removeFromCart'])
        ->name('cart.remove'); 
     
    Route::get('/user/{id}/profile', [UserController::class, 'show'])
        ->name('users.show');
    Route::put('/user/{id}/edit', [UserController::class, 'update'])
        ->name('users.update');
    Route::put('/user/{id}/changePassword', [UserController::class, 'changePassword'])
        ->name('users.changePassword');
    // Route::post('/user/{id}/info', [UserController::class, 'storeInfo'])
    //     ->name('users.info');          
});

// admin routes
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [AdminLoginController::class, 'create'])->name('admins.login');
    Route::post('/login', [AdminLoginController::class, 'store']);
    Route::middleware('admin')->name('admins.')->group( function() {
        Route::get('/', [AdminLoginController::class, 'index'])->name('adminLte');
        Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('logout');
        
        Route::get('/users/index', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}/show', [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/users/{id}/ban', [AdminUserController::class, 'ban'])->name('users.ban');
        Route::get('/users/{id}/unban', [AdminUserController::class, 'unban'])->name('users.unban');
        
        Route::get('shops/index', [AdminShopController::class, 'index'])->name('shops.index');
        Route::get('shops/{id}/show', [AdminShopController::class, 'show'])->name('shops.show');
        Route::get('shops/{id}/edit', [AdminShopController::class, 'edit'])->name('shops.edit');
        Route::put('shops/{id}/edit', [AdminShopController::class, 'update']);
        Route::delete('shops/{id}/delete', [AdminShopController::class, 'destroy'])->name('shops.destroy');
        Route::get('shops/{id}/approve', [AdminShopController::class, 'approveMail'])->name('shops.approve');
        Route::get('shops/{id}/decline', [AdminShopController::class, 'rejectMail'])->name('shops.reject');
        Route::get('receipts/index', [AdminShopController::class, 'showReceipt'])->name('receipts.index');

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/adminusers/index', [AdminController::class, 'index'])->name('adminUsers.index');
        Route::post('/adminusers/create', [AdminController::class, 'store'])->name('adminUsers.create');
        Route::put('/adminusers/{id}/update', [AdminController::class, 'update'])->name('adminUsers.update');
        Route::delete('/adminusers/{id}/delete', [AdminController::class, 'destroy'])->name('adminUsers.destroy');

        Route::get('/menuTypes/index', [AdminMenuTypeController::class, 'index'])->name('menuTypes.index');
        Route::post('/menuTypes/create', [AdminMenuTypeController::class, 'store'])->name('menuTypes.store');
        Route::put('/menuTypes/{id}/edit', [AdminMenuTypeController::class, 'update'])->name('menuTypes.update');
        Route::delete('/menuTypes/{id}/delete', [AdminMenuTypeController::class, 'destroy'])->name('menuTypes.destroy');

        Route::get('/users/edit/{user}', [AdminUserController::class, 'edit'])->name('admins.users.edit');
        Route::post('users/edit/{user}', [AdminUserController::class, 'update'])->name('admins.users.update');
        Route::get('/sendEmail/{id}', [SendEmailController::class, 'index'])->name('adminLte.sendEmail');

        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/list', [CategoryController::class, 'list'])->name('categories.list');
        Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::post('/categories/edit/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::get('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');
    });
});