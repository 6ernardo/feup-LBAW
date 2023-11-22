@extends('layouts.app')

@section('content')
    <form id="searchForm" action="/search" method="get">
        <label for="search">Search:</label>
        <input type="text" id="search" name="q" placeholder="Search a question">
        <button type="submit">Search</button>
    </form>
@endsection 