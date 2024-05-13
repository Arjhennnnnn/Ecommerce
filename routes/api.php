<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\api\v1\UserController;
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

Route::group(['prefix' => 'v1'], function () {


    // Authentication
    Route::group(['prefix' => 'auth'], function () {

        Route::post('login', [AuthController::class, 'login']);

        Route::post('register', [AuthController::class, 'register']);

        Route::group(['middleware' => 'auth.jwt'], function () {

            Route::post('logout', [AuthController::class, 'logout']);

            Route::get('me', [AuthController::class, 'me']);

            Route::get('refresh', [AuthController::class, 'refresh']);
        });

    });

    Route::apiResource('users', UserController::class);

});
