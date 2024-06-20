<?php

use App\Http\Controllers\Sale\SendExpressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('webhook', [SendExpressController::class, 'webhook'])->name('webhook');
