@extends('layouts.app')

@section('content')
    <h2>{{ $tag->name }}</h2>
    <p>{{ $tag->description }}</p>
    <div>
    <a class="button" href="{{ url('/tags/'.$tag->tag_id.'/edit') }}"> Edit Tag </a>
    <form method="POST" action="{{ url('/tags/'.$tag->tag_id.'/delete') }}">
            @method('DELETE')
            @csrf
            <button type="submit">Delete Tag</button>
        </form>
        </div>
@endsection