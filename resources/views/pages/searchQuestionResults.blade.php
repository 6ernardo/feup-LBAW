@extends('layouts.app')

@section('content')

<section id="feed">
    <h1>Questions</h1>
    @foreach($questions as $question)
        <article class="question">
        <a href="{{ url('/questions/'.$question->question_id) }}">{{ $question->title }}</a>
        </article>
    @endforeach
</section>
