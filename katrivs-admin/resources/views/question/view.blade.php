@extends("master")
@section("title", $game->title)
@section("content")

    <div class="game-description">
        <div class="container mb-5">
            <div class="card p-3 mt-3" style="margin: auto; max-width: 600px; text-align: center;">
                <div class="card-body">
                    <h3>{{ $game->title  }}</h3>
                    <p>{{ $game->description }}</p>
                    <a href="{{ route("playground", ['triviaId' => $game->id]) }}" class="btn btn-success btn-sm">Generate
                        code</a> | <a href="{{ route("game.edit", ["id" => $game->id])  }} }}"
                                      class="btn btn-sm btn-primary">Edit Game</a> | <a href="{{ route("home") }}"
                                                                                        class="btn btn-sm btn-secondary">Back
                        home</a>
                </div>
            </div>
        </div>

        <div class="container">
            <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="questions-tab" data-bs-toggle="tab"
                            data-bs-target="#questions-tab-pane"
                            type="button" role="tab" aria-controls="questions-tab-pane" aria-selected="true">Questions
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history-tab-pane"
                            type="button" role="tab" aria-controls="history-tab-pane" aria-selected="false">Game History
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="questions-tab-pane" role="tabpanel"
                 aria-labelledby="questions-tab" tabindex="0">

                <div class="questions list-group p-3" style="max-width: 600px; margin: auto; text-align: center;">


                    @foreach($game->questions as $question)
                        <div class="question-item list-group-item">
                            <h5>{{ $question->name }}</h5>
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <p>{{ $question->option1  }}</p>
                                </div>
                                <div class="col-md-6 text-center">
                                    <p>{{ $question->option2  }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <p>{{ $question->option3  }}</p>
                                </div>
                                <div class="col-md-6 text-center">
                                    <p>{{ $question->option4  }}</p>
                                </div>
                            </div>

                            <p>Answer: <span class="badge bg-success">{{ $question->answer }}</span></p>

                            <a href="{{ route('question.edit', ['id' => $question->id]) }}"
                               class="btn btn-sm btn-primary">Edit</a> | <a
                                href="{{ route('question.delete', ['id' => $question->id]) }}" class="btn btn-sm btn-danger">Delete</a>
                        </div>
                        <br/>
                    @endforeach
                </div>


            </div>
            <div class="tab-pane fade" id="history-tab-pane" role="tabpanel" aria-labelledby="history-tab"
                 tabindex="0">
                <div class="container">
                    <h1>History pane</h1>
                </div>
            </div>


        </div>

    </div>
@endsection
