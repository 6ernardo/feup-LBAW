@extends('layouts.app')

@section('content')
    <section id="edit_answer">
        <form method="POST" action="{{ '/answers/'.$answer->answer_id.'/edit' }}">
            @method('PUT')
            @csrf
            <label for="description">Description:</label>
            <textarea name="description" id="description" placeholder="{{ $answer->description }}" value="{{ old('description') }}" required></textarea>

            <button type="submit">Submit</button>
        </form>
    </section>
@endsection