<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlaygroundController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('game.index');
//})->name("home");

Route::get('/', [GameController::class, 'index'])->name("home");
Route::get('/create', [GameController::class, 'create'])->name("game.create");
Route::post('/store', [GameController::class, 'store'])->name("game.store");
Route::get("/game/view/{id}", [GameController::class, 'view_game'])->name("game.view");
Route::get("/game/edit/{id}", [GameController::class, 'edit_game'])->name("game.edit");
Route::post("/game/update/{id}", [GameController::class, 'store_game'])->name('game.save');
Route::post("/game/start/{id}", [GameController::class, 'start_game'])->name("game.start");

Route::get('/{id}', [GameController::class, 'get_question'])->name("question");
Route::post("/question/{id}", [GameController::class, 'post_question'])->name("question.create");
Route::get("/question/delete/{id}", [GameController::class, 'delete_question'])->name('question.delete');
Route::get("/question/edit/{id}", [GameController::class, 'edit_question'])->name("question.edit");
Route::post("/question/save/{id}", [GameController::class, 'save_edit'])->name("question.save");

// PlayGround

Route::get("/playground/{triviaId}", [PlaygroundController::class, "index"])->name("playground");
