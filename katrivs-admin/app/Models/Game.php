<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function history(){
        return $this->hasMany(GameHistory::class);
    }
}
