
<div class="container">
    <div class="game-description">
        <fieldset style="margin: auto; max-width: 600px; text-align: center;">
            <h3>{{ $game->title  }}</h3>
            <p>{{ $game->description }}</p>
            <a href="{{ route("playground", ['triviaId' => $game->id]) }}">Generate code</a> | <a href="{{ route("game.edit", ["id" => $game->id])  }} }}">Edit Game</a> | <a href="{{ route("home") }}">Back home</a>
        </fieldset>

        <div class="questions" style="max-width: 600px; margin: auto; text-align: center;">
            <h3>Questions</h3>

            @foreach($game->questions as $question)
            <div class="question-item">
                <h3>{{ $question->name }}</h3>
                <table style="width:100%">
                    <tr>
                        <td style="text-align: center">
                            <p>{{ $question->option1  }}</p>
                        </td>
                        <td style="text-align: center">
                            <p>{{ $question->option2  }}</p>
                        </td>
                    </tr>
                    <tr style="margin-top: 50px">
                        <td style="text-align: center">
                            <p>{{ $question->option3  }}</p>
                        </td>
                        <td style="text-align: center">
                            <p>{{ $question->option4  }}</p>
                        </td>
                    </tr>
                </table>
                <p>Answer: {{ $question->answer }}</p>

                <a href="{{ route('question.edit', ['id' => $question->id]) }}">Edit</a> | <a href="{{ route('question.delete', ['id' => $question->id]) }}">Delete</a>
            </div>
                <hr />
            @endforeach
        </div>

    </div>
</div>

<script>

</script>
