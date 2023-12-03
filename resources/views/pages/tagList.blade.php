@extends('layouts.app')

@section('content')
<h1>All Tags</h1>
    <ul>
        @foreach($tags as $tag)
        <a class="button" href="{{ url('/tags/'.$tag->tag_id) }}">{{ $tag->name }}</a>
        @endforeach
    </ul>
@endsection
