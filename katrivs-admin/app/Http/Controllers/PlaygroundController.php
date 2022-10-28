<?php

namespace App\Http\Controllers;

use App\Models\GameHistory;
use App\Models\Players;
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

    public function view($code){
        $players = Players::where('game_code', $code)->get()->sortBy("score", SORT_REGULAR, true);
        return view("playground.view", ['players' => $players]);
    }


}
