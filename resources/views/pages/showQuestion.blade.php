@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/vote.css') }}">
    @if (Auth::user()->user_id == $question->author_id)
        <a class="button" href="{{ url('/questions/'.$question->question_id.'/edit') }}"> Edit Question </a>
        <form method="POST" action="{{ url('/questions/'.$question->question_id.'/delete') }}">
            @method('DELETE')
            @csrf
            <button type="submit">Delete Question</button>
        </form>
    @endif
    <h2>{{ $question->title }}</h2>
    @if (!$question->tags->isEmpty())
        <ul class="tag-list">
        <span>Tags:</span>
            @foreach($question->tags as $tag)
                <li>{{ $tag->name }}</li>
            @endforeach
        </ul>
    @endif
    <div class="question" id="question{{ $question->question_id }}">
        <p>{{ $question->description }}</p>
        <p>posted by {{ $question->author->name }}</p>
            <button class="button-vote upvote-button" onclick="voteQuestion({{ $question->question_id }}, 1)">Upvote</button>
            <span class="score">{{ $question->score }}</span>
            <button class="button-vote downvote-button" onclick="voteQuestion({{ $question->question_id }}, -1)">Downvote</button>
            <button class="button-vote remove-vote-button" onclick="removeVoteQuestion({{ $question->question_id }})">Remove Vote</button>
    </div>
    <section id="question_comments">
        <h4>Question Comments</h4>
        @each('partials.commentquestion', $question->comments, 'comment')
    </section>

    <section id="post_question_comment">
        <form method="POST" action="{{ url('questions/'.$question->question_id.'/comment/create') }}">
            @csrf
            <textarea name="content" id="content" placeholder="Type your comment here..." value="{{ old('description') }}" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </section>

    <section id="answers">
    <h3>Answers</h3>
    @foreach ($question->answers as $answer)
    <div class="answer" id="answer{{ $answer->answer_id }}">
        <p>{{ $answer->description }}</p>
        <button class="button-vote upvote-button" onclick="vote({{ $answer->answer_id }} , 1)">Upvote</button>
        <span class="score">{{ $answer->score }}</span>
        <button class="button-vote downvote-button" onclick="vote({{ $answer->answer_id }} , -1)">Downvote</button>
        <button class="button-vote remove-vote-button" onclick="removeVote({{ $answer->answer_id }})">Remove Vote</button>
    </div>
    @endforeach
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
    <script src="{{ asset('js/vote.js') }}"></script>
@endsection