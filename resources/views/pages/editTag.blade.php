@extends('layouts.app')

@section('content')
    <section id="edit_tag">
        <form method="POST" action="{{ '/tags/'.$tag->tag_id.'/edit' }}">
            @method('PUT')
            @csrf
            <label for="name">Name:</label>
            <input type="text" name="title" id="title" placeholder="{{ $tag->name }}" value="{{ old('name') }}">

            <label for="description">Description:</label>
            <textarea name="description" id="description" placeholder="{{ $tag->description }}" value="{{ old('description') }}"></textarea>

            <button type="submit">Submit</button>
        </form>
    </section>
@endsection