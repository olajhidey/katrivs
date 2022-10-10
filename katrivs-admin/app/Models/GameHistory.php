<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameHistory extends Model
{

    protected  $fillable = [ "status", "code", "trivia_id" ];

    use HasFactory;

    function players(){
        return $this->hasMany(Players::class);
    }
}
