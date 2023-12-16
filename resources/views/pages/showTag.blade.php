@extends('layouts.app')

@section('content')
    @if(Auth::check() && Auth::user()->isAdmin())
        <div>
            <a class="button" href="{{ url('/tags/'.$tag->tag_id.'/edit') }}"> Edit Tag </a>
        </div>
    @endif
    <h2>Questions with Tag: {{ $tag->name }}</h2>
    <p>{{ $tag->description }}</p>
    @forelse($tag->questions as $question)
        <div class="question">
            <a href="{{ url('/questions/'.$question->question_id) }}">
                <h2>{{ $question->title }}</h2>
                <p>{{ $question->description }}</p>
                <p>Score: {{ $question->score }}</p>
            </a>
        </div>
    @empty
        <p>No Questions to show.</p>
    @endforelse
@endsection