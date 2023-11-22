@extends('layouts.app')

@section('content')

<section id="feed">
    <h1>Questions</h1>
    @foreach($questions as $question)
        <div class="searchQuestions">
            <h2>{{$question->title}}</h2>
            <p>{{$question->description}}</p>
            <p>Pontuacão: {{$question->score}}</p>
        </div>
    @endforeach
</section>
