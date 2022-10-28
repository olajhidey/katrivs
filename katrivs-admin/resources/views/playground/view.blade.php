@extends("master")
@section("title", "Game details")
@section("content")

    <div class="container p-3" style="max-width: 700px">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Score</th>
            </tr>
            </thead>

            <tbody>

            @foreach($players as $player)
                <tr>
                    <td>{{ $player->username }}</td>
                    <td>{{ $player->score }}</td>
                </tr>
            @endforeach
            </tbody>

        </table>

    </div>

@endsection
