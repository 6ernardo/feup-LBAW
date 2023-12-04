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
    @if ($question->tags->isEmpty())
        <p>No tags available</p>
    @else
        <ul class="tag-list">
        <span>Tags:</span>
            @foreach($question->tags as $tag)
                <li>{{ $tag->name }}</li>
            @endforeach
        </ul>
    @endif
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
    <style>
        .tag-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tag-list li {
            display: inline;
            margin-right: 5px; 
        }
    </style>
@endsection