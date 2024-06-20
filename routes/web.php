<?php

use App\Http\Controllers\Access\ForgoutController;
use App\Http\Controllers\Access\LoginController;
use App\Http\Controllers\Access\RegisterController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Sale\SendExpressController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('logon', [LoginController::class, 'logon'])->name('logon');

Route::get('register/{code?}', [RegisterController::class, 'register'])->name('register');
Route::post('registrer-user', [RegisterController::class, 'registrer'])->name('registrer-user');

Route::get('forgout', [ForgoutController::class, 'forgout'])->name('forgout');
Route::post('send-forgout', [ForgoutController::class, 'sendForgout'])->name('send-forgout');

Route::get('/send-express/{product}/{seller}', [SendExpressController::class, 'checkoutExpress'])->name('send-express');
Route::post('send-sale', [SendExpressController::class, 'sendSale'])->name('send-sale');

Route::middleware(['auth'])->group(function () {

    Route::get('/app', [AppController::class, 'app'])->name('app');

    //Product
    Route::get('/list-product', [ProductController::class, 'listProducts'])->name('list-product');
    Route::get('/create-product/{id?}', [ProductController::class, 'createProduct'])->name('create-product');
    Route::post('update-product', [ProductController::class, 'updateProduct'])->name('update-product');
    Route::post('delete-product', [ProductController::class, 'deleteProduct'])->name('delete-product');
    Route::post('send-image-product', [ProductController::class, 'sendImageProduct'])->name('send-image-product');
    Route::get('/delete-image-product/{id?}', [ProductController::class, 'deleteImageProduct'])->name('delete-image-product');

    //User
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('update-user', [UserController::class, 'updateUser'])->name('update-user');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});