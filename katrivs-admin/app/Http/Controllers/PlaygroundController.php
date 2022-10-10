<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class PlaygroundController extends Controller
{
    //
    public function index($triviaId){
        $trivia = Game::find($triviaId);
        $gameCode = mt_rand(1221, 8096);

        return view("playground.index", ['trivia'=> $trivia, 'code' => $gameCode]);
    }
}
