@extends('layouts.app')

@section('content')
    @if (Auth::user()->user_id == $question->author_id)
        <a class="button" href="{{ url('/questions/'.$question->question_id.'/edit') }}"> Edit Question </a>
        <form method="POST" action="{{ url('/questions/'.$question->question_id.'/delete') }}">
            @method('DELETE')
            @csrf
            <button type="submit">Delete Question</button>
        </form>
    @endif
    <h2>{{ $question->title }}</h2>
    <p>{{ $question->description }}</p>
@endsection