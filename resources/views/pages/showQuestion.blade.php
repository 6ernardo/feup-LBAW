@extends('layouts.app')

@section('content')
    @if (Auth::check() && (Auth::user()->user_id == $question->author_id || Auth::user()->is_moderator || Auth::user()->isAdmin()))
        <a class="button" href="{{ url('/questions/'.$question->question_id.'/edit') }}"> Edit Question </a>
        <form id="deletequestion" method="POST" action="{{ url('/questions/'.$question->question_id.'/delete') }}">
            @method('DELETE')
            @csrf
            <button type="submit">Delete Question</button>
        </form>
    @endif
    @if(Auth::check() && Auth::user()->user_id != $question->author_id)
        @if(Auth::user()->follows_question($question->question_id))
            <button class="follow_question_button" onclick="follow_question({{$question->question_id}})">Unfollow</button>
        @else
            <button class="follow_question_button" onclick="follow_question({{$question->question_id}})">Follow</button>
        @endif
    @endif
    <div class="question" id="question{{ $question->question_id }}">
            <button class="button-vote upvote-button" id="button-vote upvote-button" onclick="voteQuestion({{ $question->question_id }}, 1)">Upvote</button>
            <span id="score">{{ $question->score }}</span>
            <button class="button-vote downvote-button" id="button-vote downvote-button" onclick="voteQuestion({{ $question->question_id }}, -1)">Downvote</button>
            <button class="button-vote remove-vote-button" onclick="removeVoteQuestion({{ $question->question_id }})">Remove Vote</button>
    </div>
    <h2>{{ $question->title }}</h2>
    @if (!$question->tags->isEmpty())
        <ul class="tag-list">
        <span>Tags:</span>
            @foreach($question->tags as $tag)
              <a class="button" href="{{ url('/tags/'.$tag->tag_id) }}"> {{$tag->name}} </a>
            @endforeach
        </ul>
    @endif
    <p>posted by {{ $question->author->name }} </p>
    <p>{{ $question->description }}</p>


    <section id="question_comments">
    <h4>Question Comments</h4>
    <section id="post_question_comment">
        <form method="POST" action="{{ url('questions/'.$question->question_id.'/comment/create') }}">
            @csrf
            <textarea name="content" id="content" placeholder="Type your comment here..." value="{{ old('description') }}" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </section>
        @each('partials.commentquestion', $question->comments, 'comment')
    </section>

    

    <section id="answers">
        @if (isset($question->correct_answer_id))
        <div id="correct_answer">
            <h3>Correct Answer</h3>
                @include('partials.answer', ['answer' => $question->correct_answer])
        </div>
        @endif

        <h3>Answers</h3>
        <section id="post_answer">
        <form method="POST" action="{{ url('questions/'.$question->question_id.'/answer/create') }}">
            @csrf
            <textarea name="description" id="description" placeholder="Type your answer here..." value="{{ old('description') }}" required></textarea>
            <button type="submit">Submit</button>
        </form>
        </section>

        @each('partials.answer', $question->answers, 'answer')
        
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
    <link rel="stylesheet" href="{{ asset('css/vote.css') }}">
@endsection