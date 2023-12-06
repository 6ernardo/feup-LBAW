@extends('layouts.app')

@section('content')
    <section id="edit_comment">
        <form method="POST" action="{{ '/comment'.$type.'/'.$comment->comment_id.'/edit' }}">
            @method('PUT')
            @csrf
            <label for="content">Content:</label>
            <textarea name="content" id="content" placeholder="{{ $comment->content }}" value="{{ old('content') }}" required></textarea>

            <button type="submit">Submit</button>
        </form>
    </section>
@endsection