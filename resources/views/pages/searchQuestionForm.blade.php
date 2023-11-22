@extends('layouts.app')

@section('content')
    <section id="searchQuestionForm">
        <form method="get">
            <label for="search">Search:</label>
            <input type="text" id="search_query" name="search_query" placeholder="Search a question">
            <button id="submitSearch"> Go </button> 
        </form>
    </section>
    <h1>Questions</h1>
        <section id="results">
            
        </section>
    
@endsection 