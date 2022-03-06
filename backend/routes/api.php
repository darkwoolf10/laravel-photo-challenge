<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ChallengeController;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
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

Route::middleware('api')->get('/check', function () {
    return json_encode([
        'message' => 'done!'
    ]);
});

Route::get('users', [UserController::class, 'users']);

Route::group(['prefix' => 'challenge'], function () {
    Route::get('all', [ChallengeController::class, 'index'])->name('all-challenges');
    Route::post('create', [ChallengeController::class, 'create'])->name('create-challenge');
    Route::get('show/{id}', [ChallengeController::class, 'show'])->name('show-challenge');
    Route::put('edit/{id}', [ChallengeController::class, 'edit'])->name('edit-challenge');
    Route::delete('delete/{id}', [ChallengeController::class, 'delete'])->name('delete-challenge');
    Route::post('set-photo', [ChallengeController::class, 'setPhoto'])->name('set-photo-challenge');
    Route::post('check', [ChallengeController::class, 'check'])->name('check-challenge');
});

// AUTH
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [AuthController::class, 'signup']);

    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh',  [AuthController::class, 'refresh']);
    });
});

