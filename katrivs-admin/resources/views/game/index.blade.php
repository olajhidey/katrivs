<div class="container" style="max-width: 800px; margin: auto;">
    <a href="{{ route('game.create') }}">Create a new game</a>

    <div class="games">

        @foreach($games as $game)
            <div class="game">
                <h3>{{ $game->title }}</h3>
                <p>{{ $game->description }}</p>

                <a href="{{route('question', ['id'=> $game->id])}}">Add Questions</a> | <a href="{{ route('game.view', ['id' => $game->id]) }}">View game</a> | <a href="">Start game</a>
            </div>
            <hr/>
        @endforeach

    </div>
</div>
