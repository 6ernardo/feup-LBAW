@extends('layouts.app')

@section('content')
<a class="button" href="{{ url('/questions/create') }}"> Post Question </a>

<section id="feed">
    <h1>Top Questions</h1>
    @if(isset($topQuestions) && $topQuestions->count() > 0)
        @foreach ($topQuestions as $question)
            <div class="topQuestion">
                <a href="{{ url('/questions/'.$question->question_id) }}">
                    <h2>{{$question->title}}</h2>
                    <p>{{$question->description}}</p>
                </a>
                <p>Pontuacão: {{$question->score}}</p>
            </div>
        @endforeach
    @else
        <p>No Questions to show.</p>
    @endif

    <h1>New Questions</h1>
    @if(isset($newQuestions) && $newQuestions->count() > 0)
        @foreach ($newQuestions as $question)
            <div class="newQuestion">
                <a href="{{ url('/questions/'.$question->question_id) }}">
                    <h3>{{$question -> title}}</h3>
                    <p>{{$question->description}}</p>
                </a>
                <p>Pontuacão: {{$question->score}}</p>
            </div>
        @endforeach
    @else
        <p>No Questions to show.</p>
    @endif
</section>
@endsection