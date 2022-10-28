<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Question;
use App\Models\GameHistory;
use Illuminate\Http\Request;
use App\Models\Players;

class GameController extends Controller
{
    //
    public function index(){
        return view('game.index', ['games' => Game::all()]);
    }

    public function create(){
        return view('game.create');
    }

    public function store(Request $request){
        $validate = $request->validate([
            'title' => 'required'
        ]);

        $title = $request->get("title");
        $description = $request->get("description");

        $game = Game::create([
            'title' => $title,
            'description' => $description
        ]);

        return redirect()->route("home");
    }

    public function view_game($id){

        $history = GameHistory::where('trivia_id', $id)->get()->sortDesc();
        return view('question.view', ['game' => Game::find($id), 'histories' => $history]);
    }

    public function get_question($id){
        return view('question.index', ['id' => $id]);
    }

    public function post_question(Request $request, $id){
        $validate = $request->validate([
            'name' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'answer' => 'required'
        ]);

        $saveData = Question::create([
            'name' => $request->get("name"),
            'option1' => $request->get("option1"),
            "option2" => $request->get("option2"),
            "option3" => $request->get("option3"),
            "option4" => $request->get("option4"),
            "answer" => $request->get("answer"),
            "game_id" => $id
        ]);

        return redirect()->back();
    }

    public function edit_game($id){
        return view('game.edit', ['game' => Game::find($id)]);
    }

    public function games($id){

        $response = array("game" => Game::find($id), "questions"=> Game::find($id)->questions );

        return response()->json($response);
    }

    public function start_game($id, Request $request){

        $code = $request->input("code");

        $item = GameHistory::where("code", $code)->first();

        if($item){
            return response()->json(["success"=> false, "message" => "Game already ended. Start a new game"]);
        }

        $start = GameHistory::create([
            'status' => $request->input("status"),
            'code' => $request->input("code"),
            'trivia_id'=> $id
        ]);

        return response()->json(["success"=> true, "message" => "Item saved successfully"]);
    }

    public function save_game($id, Request $request){
        $created = Players::create([
            'game_id' => $request->input('game_id'),
            'score' => $request->input('score'),
            'username' => $request->input('username')
        ]);

        return response()->json(["message" => "User saved successfully"]);
    }

    public function update_game($id, Request $request){
        $game = GameHistory::where('code', $request->input("code"))->first();

        if (!$game){
            return response()->json(["message" => "Game code not found"]);
        }
        $game->status = $request->input("status");
        $game->save();

        return response()->json(["message" => "Game updated successfully", "data" => $game]);

    }

    public function store_game(Request $request, $id){
        $game = Game::find('code', $request->input("code"));
        $game->title = $request->get("title");
        $game->description = $request->get("description");
        $game->save();
        return redirect()->route("game.view", ["id" => $id]);
    }

    public function delete_question($id){
        $question = Question::find($id);
        $question->delete();

        return redirect()->back();
    }

    public function edit_question($id){
        return view("question.edit", ['question' => Question::find($id)]);
    }

    public function save_edit(Request $request, $id){
        $question = Question::find($id);
        $question->name = $request->get("name");
        $question->option1 = $request->get("option1");
        $question->option2 = $request->get("option2");
        $question->option3 = $request->get("option3");
        $question->option4 = $request->get("option4");
        $question->answer = $request->get("answer");

        $question->save();

        return redirect()->route('game.view', ['id' => $question->game_id]);
    }

    public function remove($code){
        $history = GameHistory::where("code", $code)->first();
        $players = Players::where("code", $code);

        $players->delete();
        $history->delete();

        return redirect()->back();
    }

}
