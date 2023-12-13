@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ url('/tags/'.$tag->tag_id.'/delete') }}">
        @method('DELETE')
        @csrf
        <button type="submit">Delete Tag</button>
    </form>
    <section id="edit_tag">
        <form method="POST" action="{{ '/tags/'.$tag->tag_id.'/edit' }}">
            @method('PUT')
            @csrf
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="{{ $tag->name }}" value="{{ old('name') }}">

            <label for="description">Description:</label>
            <textarea name="description" id="description" placeholder="{{ $tag->description }}" value="{{ old('description') }}"></textarea>

            <button type="submit">Submit</button>
        </form>
    </section>
@endsection