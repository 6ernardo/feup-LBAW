@extends('layouts.app')

@section('content')
    <section id="search_form">
        <form method="get" action="{{ route('search') }}">
            <label for="search">Search:</label>
            <input type="text" id="search" name="q" placeholder="Search a question">
            <button type="submit">Search</button>
        </form>
    </section>
@endsection 