<div class="container">

    <h3>Create a new Game</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('game.save', ['id' => $game->id]) }}" method="post">

        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" value="{{$game->title}}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea type="text" name="description">{{ $game->description }}</textarea>
        </div>

        <br />
        <button type="submit">Save</button> | <a href="{{ route("game.edit", ['id' => $game->id]) }}">Go back</a>

    </form>

</div>
