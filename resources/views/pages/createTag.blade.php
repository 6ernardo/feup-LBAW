@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ '/tags/create' }}">
        {{ csrf_field() }}

        <label for="name">Tag Name</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
        @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
        @endif

        <label for="description">Tag Description</label>
        <textarea id="description" name="description" required>{{ old('description') }}</textarea>
        @if ($errors->has('description'))
        <span class="error">
            {{ $errors->first('description') }}
        </span>
        @endif

        <button type="submit">
            Create Tag
        </button>
    </form>
@endsection
