@extends('layouts.app')

@section('content')
    <h1>My Questions</h1>
    <ul>
        @foreach($userQuestions as $question)
            <li>
            <a class="button" href="{{ url('/questions/'.$question->question_id) }}">{{ $question->title }}</a>
        @endforeach
    </ul>
@endsection