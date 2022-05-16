<?php

use App\Infrastructure\Controllers\CreateWalletController;
use App\Infrastructure\Controllers\GetUserController;
use App\Infrastructure\Controllers\CoinStatusController;
use App\Infrastructure\Controllers\IsEarlyAdopterUserController;
use App\Infrastructure\Controllers\SellCryptoController;
use App\Infrastructure\Controllers\StatusController;
use App\Infrastructure\Controllers\GetWalletBalanceController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get(
    '/status',
    StatusController::class
);

Route::get('user/{email}', IsEarlyAdopterUserController::class);
Route::get('user/id/{userId}', GetUserController::class);
Route::get('wallet/{wallet_id}/balance', GetWalletBalanceController::class);
Route::get('coin/status/{coinId}', CoinStatusController::class);
Route::post('wallet/open', CreateWalletController::class);
Route::post('coin/sell', SellCryptoController::class);


