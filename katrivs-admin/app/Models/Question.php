<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'option1', 'option2', 'option3', 'option4', 'answer','game_id'];

    public function game(){
        return $this->belongsTo(Game::class);
    }
}
