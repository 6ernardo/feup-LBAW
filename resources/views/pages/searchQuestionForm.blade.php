@extends('layouts.app')

@section('content')
    <section id="searchQuestionForm">
        <form method="get" action="searchQuestionResults">
            <label for="search">Search:</label>
            <input type="text" id="search" name="q" placeholder="Search a question">
            <a class="button" href="{{ route('searchQuestionResults') }}"> Go </a> 
        </form>
    </section>
@endsection 