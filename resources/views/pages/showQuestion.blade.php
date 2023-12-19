@extends('layouts.app')

@section('content')
<<<<<<< 0b9db1db833d928796327de9546417279b46a3a4
    @if (Auth::check() && Auth::user()->user_id == $question->author_id)
=======
    @if (Auth::check() && (Auth::user()->user_id == $question->author_id || Auth::user()->is_moderator || Auth::user()->isAdmin()))
>>>>>>> 6dc2c54649f4263ea7a137054af70bd28ef1f2d6
        <a class="button" href="{{ url('/questions/'.$question->question_id.'/edit') }}"> Edit Question </a>
        <form method="POST" action="{{ url('/questions/'.$question->question_id.'/delete') }}">
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
    <h2>{{ $question->title }}</h2>
    @if (!$question->tags->isEmpty())
        <ul class="tag-list">
        <span>Tags:</span>
            @foreach($question->tags as $tag)
                <li>{{ $tag->name }}</li>
            @endforeach
        </ul>
    @endif
    <p>posted by {{ $question->author->name }} </p>
    <p>{{ $question->description }}</p>

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
        @if (isset($question->correct_answer_id))
        <h3>Correct Answer<h3>
            @include('partials.answer', ['answer' => $question->correct_answer])
        @endif
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