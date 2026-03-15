<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;

Route::post('/purchase', [PurchaseController::class, 'purchase']);

