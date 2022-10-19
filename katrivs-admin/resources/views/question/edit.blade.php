@extends("master")
@section("title", "Add Question")
@section("content")
<div class="container p-3" style="max-width: 800px;">

    <h3>Add Question</h3>

    <form method="post" action="{{route('question.save', ['id' => $question->id])}}">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $question->name }}">
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="option1">Option 1</label>
                    <input type="text"  class="form-control" name="option1" value="{{ $question->option1 }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="option2">Option 2</label>
                    <input type="text" name="option2" class="form-control" value="{{ $question->option2 }}">
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label for="option3">Option 3 (Optional) </label>
                    <input type="text" name="option3" class="form-control" value="{{ $question->option3 }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="option4">Option 4 (Optional) </label>
                    <input type="text" name="option4" class="form-control" value="{{ $question->option4 }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="answer">Answer</label>
            <input type="text" name="answer" class="form-control" value="{{ $question->answer }}">
        </div>

        <br>
        <button type="submit" class="btn btn-primary">Save Changes</button>

        <a href="{{route('game.view', ['id' => $question->game_id])}}">Go back</a>

    </form>

</div>
@endsection
