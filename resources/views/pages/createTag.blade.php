@extends('layouts.app')

@section('content')
    <section id="create_tag">
         <form method="POST" action="{{ '/tags/create' }}">
            {{ csrf_field() }}
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Tag Name" value="{{ old('name') }}">

            <label for="description">Description:</label>
            <textarea name="description" id="description" placeholder="Tag Description">{{ old('description') }}</textarea>

            <button type="submit">Submit</button>
        </form>
    </section>
@endsection