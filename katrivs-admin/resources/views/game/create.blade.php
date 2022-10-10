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

    <form action="{{ route('game.store') }}" method="post">

        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" placeholder="Enter description of Game">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea type="text" name="description"></textarea>
        </div>

       <button type="submit">Create game</button>

    </form>

</div>
