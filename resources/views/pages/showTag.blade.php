@extends('layouts.app')

@section('content')
    @if(Auth::check())
        @if(Auth::user()->isAdmin())
            <div>
                <a class="button" href="{{ url('/tags/'.$tag->tag_id.'/edit') }}"> Edit Tag </a>
            </div>
        @endif
        @if(Auth::user()->follows_tag($tag->tag_id))
            <button class="follow_tag_button" onclick="follow_tag({{$tag->tag_id}})">Unfollow</button>
        @else
            <button class="follow_tag_button" onclick="follow_tag({{$tag->tag_id}})">Follow</button>
        @endif
    @endif
    <h2>Questions with Tag: {{ $tag->name }}</h2>
    <p>{{ $tag->description }}</p>
    <section id="tag_questions">
    @forelse($tag->questions as $question)  
        <div class="question">
            <a href="{{ url('/questions/'.$question->question_id) }}">
                <h2>{{ $question->title }}</h2>
                <p>Score:{{ $question->score }} | posted by {{ $question->author->name }} on {{ $question->timestamp }} </p>
            </a>
        </div>
    @empty
        <p>No Questions to show.</p>
    @endforelse
    </section>
    
@endsection