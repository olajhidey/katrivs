@extends("master")
@section("title", "Add Question")
@section("content")
    <div class="container p-3" style="max-width: 800px;">

        <h3>Add Question</h3>

        <form method="post" action="{{route('question.create', ['id' => $id])}}">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name">
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="option1">Option 1</label>
                        <input type="text" class="form-control" name="option1">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="option2">Option 2</label>
                        <input type="text" class="form-control" name="option2">
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="option3">Option 3 (Optional) </label>
                        <input type="text" class="form-control" name="option3">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="option4">Option 4 (Optional) </label>
                        <input type="text" class="form-control" name="option4">
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label for="answer">Answer</label>
                <input type="text" class="form-control" name="answer">
            </div>

            <br>
            <button class="btn btn-primary" type="submit">Create Question</button>

            <a href="{{route('home')}}">Go back Home</a>

        </form>

    </div>

@endsection
