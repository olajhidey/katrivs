<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    use HasFactory;

    protected $fillable = ["username", "score", "game_id"];

    public function game_history(){
        return $this->belongsTo(GameHistory::class);
    }

}
