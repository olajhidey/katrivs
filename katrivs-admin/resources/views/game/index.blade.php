@extends('master')
@section('title', "Home")
@section('content')

<div class="container mt-5">
    <a class="btn btn-primary mb-3" href="{{ route('game.create') }}">Create a new game</a>

    <div class="list-group">

        @foreach($games as $game)
            <div class="list-group-item p-3">
                <h3>{{ $game->title }}</h3>
                <p>{{ $game->description }}</p>

                <a class="btn btn-secondary" href="{{route('question', ['id'=> $game->id])}}">Add Questions</a> | <a class="btn btn-info" href="{{ route('game.view', ['id' => $game->id]) }}">View game</a> | <a class="btn btn-success" href="">Start game</a>
            </div>
        @endforeach

    </div>
</div>
@endsection
