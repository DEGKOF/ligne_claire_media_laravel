<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\MarketDataController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// ==========================================
// ROUTES API POUR LES PUBLICITÉS (Frontend)
// ==========================================


Route::get('/market-data', [MarketDataController::class, 'index']);
