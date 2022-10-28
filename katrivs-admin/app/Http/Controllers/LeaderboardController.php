<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Players;

class LeaderboardController extends Controller
{
    //

    function create_board(Request $request){

        $board = Players::create([
            "username" => $request->input("username"),
            "score" => $request->input("score"),
            "game_id"=>$request->input("game_id"),
            "game_code" => $request->input("game_code")
        ]);

        return response()->json(["message" => "record added successfully"]);

    }

    // Get the list of score for players based on a particular code
    function get_board($gameCode){
        $board = Players::where('game_code', $gameCode)->get();
        $sorted = $board->sortBy("score", SORT_REGULAR, true)->values()->all();
        return response()->json(["data"=> $sorted]);

    }
}
