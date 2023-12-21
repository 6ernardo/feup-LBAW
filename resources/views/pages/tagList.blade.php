@extends('layouts.app')

@section('content')
@if(Auth::check() && Auth::user()->isAdmin())
<a class="button" href="/tags/create">Create Tag</a>
@endif
<h1>All Tags</h1>
    <ul>
        @foreach($tags as $tag)
        <a class="button" href="{{ url('/tags/'.$tag->tag_id) }}">{{ $tag->name }}</a>
        @endforeach
    </ul>
@endsection
