<?php

use App\Http\Controllers\Api\{AuthController, EventSportifController};
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
Route::post('register',[AuthController::class,'register']);
Route::post('login', [AuthController::class, 'login']);

Route::prefix('organisateur')->middleware(['auth:sanctum','can:organisateur-view'])->group(function (){

    Route::apiResource('eventSportifs',EventSportifController::class);
});




