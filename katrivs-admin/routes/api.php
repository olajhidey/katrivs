<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LeaderboardController;

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

Route::get("/games/{id}", [GameController::class , 'games']);
Route::post("/player/{id}", [GameController::class, 'start_game']);
Route::post("/player/save/{id}", [GameController::class, 'save_player']);
Route::put("/player/{id}", [GameController::class, "update_game"]);

//players
Route::post("/board/create", [LeaderboardController::class, "create_board"]);
Route::get("/boards/{gameCode}", [LeaderboardController::class, "get_board"]);
