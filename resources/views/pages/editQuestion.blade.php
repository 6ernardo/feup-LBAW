@extends('layouts.app')

@section('content')
    <section id="edit_question">
        <form method="POST" action="{{ '/questions/'.$question->question_id.'/edit' }}">
            @method('PUT')
            @csrf
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" placeholder="{{ $question->title }}" value="{{ old('title') }}">

            <label for="description">Description:</label>
            <textarea name="description" id="description" placeholder="{{ $question->description }}" value="{{ old('description') }}"></textarea>

            <button type="submit">Submit</button>
        </form>
    </section>
@endsection