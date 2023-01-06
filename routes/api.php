<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RestourantController;
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

Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

Route::resource('/restourant', RestourantController::class, ['only' => ['index', 'show']])->middleware(['auth:sanctum', 'ability:admin,user']);
Route::resource('/restourant', RestourantController::class, ['except' => ['index', 'show']])->middleware(['auth:sanctum', 'ability:admin']);

Route::resource('/dish', DishController::class, ['except' => ['index', 'show']])->middleware(['auth:sanctum', 'ability:admin']);
Route::resource('/dish', DishController::class, ['only' => ['index', 'show']])->middleware(['auth:sanctum', 'ability:admin,user']);

Route::post('/rating', [RatingController::class, 'store'])->middleware(['auth:sanctum', 'ability:admin,user']);
