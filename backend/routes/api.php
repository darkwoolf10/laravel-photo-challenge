<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ChallengeController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'challenge'], function () {
    Route::get('all', [ChallengeController::class, 'index'])->name('all-challenges');
    Route::get('create', [ChallengeController::class, 'create'])->name('create-challenge');
    Route::get('show/{id}', [ChallengeController::class, 'show'])->name('show-challenge');
    Route::get('edit/{id}', [ChallengeController::class, 'edit'])->name('edit-challenge');
    Route::get('delete/{id}', [ChallengeController::class, 'delete'])->name('delete-challenge');
});

// AUTH
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [UserController::class, 'user']);
    });
});

