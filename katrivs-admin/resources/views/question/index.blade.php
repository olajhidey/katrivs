<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

    <div class="container">

        <h3>Add Question</h3>

        <form method="post" action="{{route('question.create', ['id' => $id])}}">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name">
            </div>

            <div class="form-group">
                <label for="option1">Option 1</label>
                <input type="text" name="option1">
            </div>

            <div class="form-group">
                <label for="option2">Option 2</label>
                <input type="text" name="option2">
            </div>

            <div class="form-group">
                <label for="option3">Option 3 (Optional) </label>
                <input type="text" name="option3">
            </div>

            <div class="form-group">
                <label for="option4">Option 4 (Optional) </label>
                <input type="text" name="option4">
            </div>

            <div class="form-group">
                <label for="answer">Answer</label>
                <input type="text" name="answer">
            </div>

            <br>
            <button type="submit">Submit</button>

            <a href="{{route('home')}}">Go back Home</a>

        </form>

    </div>

</body>
</html>
