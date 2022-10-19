@extends('master')
@section("title", "Create Question")
@section("content")
    <div class="container p-3" style="max-width: 700px;">

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

        <form action="{{ route('game.store') }}" class="mt-3" method="post">

            @csrf

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter description of Game">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea type="text" class="form-control" name="description"></textarea>
            </div>

            <br/>
            <button class="btn btn-primary" type="submit">Create game</button>
            &nbsp;
            <a href="/">Back Home</a>
        </form>

    </div>
@endsection
