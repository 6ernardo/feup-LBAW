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
    <p>posted by {{ $question->author->name }} </p>
    <p>{{ $question->description }}</p>

    

    <section id="answers">
        <h3>Answers</h3>
        @each('partials.answer', $question->answers, 'answer')
    </section>

    <section id="post_answer">
        <form method="POST" action="{{ url('questions/'.$question->question_id.'/answer/create') }}">
            @csrf
            <textarea name="description" id="description" placeholder="Type your answer here..." value="{{ old('description') }}" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </section>
@endsection