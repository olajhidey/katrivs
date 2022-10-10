<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<div class="container">

    <h3>Add Question</h3>

    <form method="post" action="{{route('question.save', ['id' => $question->id])}}">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ $question->name }}">
        </div>

        <div class="form-group">
            <label for="option1">Option 1</label>
            <input type="text" name="option1" value="{{ $question->option1 }}">
        </div>

        <div class="form-group">
            <label for="option2">Option 2</label>
            <input type="text" name="option2" value="{{ $question->option2 }}">
        </div>

        <div class="form-group">
            <label for="option3">Option 3 (Optional) </label>
            <input type="text" name="option3" value="{{ $question->option3 }}">
        </div>

        <div class="form-group">
            <label for="option4">Option 4 (Optional) </label>
            <input type="text" name="option4" value="{{ $question->option4 }}">
        </div>

        <div class="form-group">
            <label for="answer">Answer</label>
            <input type="text" name="answer" value="{{ $question->answer }}">
        </div>

        <br>
        <button type="submit">Submit</button>

        <a href="{{route('game.view', ['id' => $question->game_id])}}">Go back</a>

    </form>

</div>

</body>
</html>
