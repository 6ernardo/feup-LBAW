@extends('layouts.app')

@section('content')
<a class="button" href="{{ url('/questions/create') }}"> Post Question </a>
<section id="feed">
    <p>Hello World!</p>
</section>

@endsection