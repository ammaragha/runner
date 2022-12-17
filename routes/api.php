<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Auth
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/getPhoneByEmail', [AuthController::class, 'getPhoneByEmail']);
    Route::post('/sendOTP', [AuthController::class, 'sendOTP']);
    Route::post('/verifyOTP', [AuthController::class, 'verifyOTP']);
    Route::post('/verify', [AuthController::class, 'verify']);
    Route::patch('/reset', [AuthController::class, 'reset']);
});


Route::group(['prefix' => 'services'], function () {
    Route::get('/', [ServiceController::class, 'index']);
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/pagination/{field}/{type}/{perPage}', [ServiceController::class, 'pagination']);
    });
});

Route::group(['prefix' => 'orders'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/', [OrderController::class, 'store']);
        Route::post('/findRunner', [OrderController::class, 'findRunner']);
        Route::patch('/changeStatus/{id}',[OrderController::class,'changeStatus']);
        Route::get('/recent/{limit}', [OrderController::class, 'recent']);
    });
});
